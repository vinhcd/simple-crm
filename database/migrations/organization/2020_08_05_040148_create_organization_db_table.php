<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationDbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_db', function (Blueprint $table) {
            $table->id();
            $table->string('dbname')->unique()->comment('organization uuid');
            $table->string('host')->nullable();
            $table->unsignedInteger('port')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_db');
    }
}
