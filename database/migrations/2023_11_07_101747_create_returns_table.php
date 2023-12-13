<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_code') -> nullable();
            $table->string('return_reason');
            $table->string('name');
            $table->string('tel_1');
            $table->string('tel_2');
            $table->string('city');
            $table->string('address');
            $table->string('return_status');
            $table->string('payment_method');
            $table->string('shipping_fee');
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
        Schema::dropIfExists('returns');
    }
}
