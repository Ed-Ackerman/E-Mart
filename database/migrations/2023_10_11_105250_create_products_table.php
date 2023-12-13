<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id()->startingValue(100); // Auto-incremental primary key
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('image')->nullable(); // Assuming 'image' is a file input
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('warranty')->nullable();
            $table->string('condition')->nullable();
            $table->string('availability')->nullable();
            $table->string('material')->nullable();
            $table->string('brand')->nullable();
            $table->string('weight')->nullable();
            $table->string('rating')->nullable();
            $table->string('expense')->nullable();
            $table->text('features')->nullable();
            $table->string('quantity')->nullable();
            $table->string('buying')->nullable();
            $table->string('selling')->nullable();
            $table->string('discount')->nullable();
            $table->string('total')->nullable();
            $table->string('profit')->nullable();
            $table->string('custom_size')->nullable();
            $table->string('custom_warranty')->nullable();
            $table->string('custom_condition')->nullable();
            $table->string('custom_availability')->nullable();
            $table->string('alert_threshold')->default(10);
            $table->timestamps();
        
            // Add more columns as needed
        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
