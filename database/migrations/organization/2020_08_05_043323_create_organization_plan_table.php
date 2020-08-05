<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_plan', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->integer('plan_id');
            $table->date('start');
            $table->date('end');
            $table->timestamps();

            $table->index('organization_id');
            $table->index('plan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_plan');
    }
}
