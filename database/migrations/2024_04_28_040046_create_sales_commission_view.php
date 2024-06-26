<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $query = DB::table('sales as s')
            ->join('sellers as sl', 'sl.id', '=', 's.seller_id')
            ->join('clients as cl', 'cl.id', '=', 's.client_id')
            ->join('companies as cp', 'cp.id', '=', 'sl.company_id')
            ->join('addresses as ad', 'ad.id', '=', 'cl.address_id')
            ->join('users as us', 'us.id', '=', 'sl.user_id')
            ->join('users as uc', 'uc.id', '=', 'cl.user_id')
            ->selectRaw('
            cp.name as company,
            us.name as seller,
            uc.name as client,
            ad.city,
            ad.state,
            s.sold_at,
            s.total_amount,
            s.status,
            round(s.total_amount * cp.commission_rate / 100) as commission
        ')->toSql();


        DB::statement("CREATE MATERIALIZED VIEW IF NOT EXISTS sales_commission_view AS $query");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS sales_commission_view');
    }
};
