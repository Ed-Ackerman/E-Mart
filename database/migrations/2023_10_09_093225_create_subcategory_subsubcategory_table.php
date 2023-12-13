<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcategorySubsubcategoryTable extends Migration
{
  
    public function up()
    {
        Schema::create('subcategory_subsubcategory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subcategory_id');
            $table->unsignedBigInteger('subsubcategory_id');
            $table->timestamps();

            $table->foreign('subcategory_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('subsubcategory_id')->references('id')->on('sub_sub_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subcategory_subsubcategory');
    }
}
