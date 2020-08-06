<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('uuid')->unique();
            $table->string('phone_number', 50)->nullable();
            $table->string('tax_number', 50)->nullable();
            $table->string('address', 500)->nullable();
            $table->date('register_date');
            $table->unsignedInteger('plan_id');
            $table->unsignedInteger('database_id');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->index('plan_id');
            $table->index('database_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization');
    }
}
