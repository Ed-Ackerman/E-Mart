<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('tel')->nullable();
            $table->string('email')->nullable();
            $table->string('location')->nullable();
            $table->string('terms')->nullable();
            $table->string('payment')->nullable();
            $table->string('product')->nullable();
            $table->string('method')->nullable();
            $table->string('custom_method')->nullable();
            $table->string('capacity')->nullable();
            $table->string('custom_lead')->nullable();
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
        Schema::dropIfExists('warehouses');
    }
}
