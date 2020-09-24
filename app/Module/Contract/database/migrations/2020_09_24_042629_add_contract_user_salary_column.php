<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContractUserSalaryColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('contract_user')) {
            Schema::table('contract_user', function (Blueprint $table) {
                $table->text('salary')->after('username')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('contract_user')) {
            Schema::table('contract_user', function (Blueprint $table) {
                $table->dropColumn('salary');
            });
        }
    }
}
