<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSubSubcategoryTable extends Migration
{
    public function up()
    {
        Schema::create('product_subsubcategory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('subsubcategory_id');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('subsubcategory_id')->references('id')->on('sub_sub_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_subsubcategory');
    }
}
