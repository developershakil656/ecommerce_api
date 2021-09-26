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
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->string('name');
            $table->longText('thumbnail')->nullable();
            $table->string('slug')->unique();
            $table->integer('on_stock')->default(0);
            $table->boolean('status',[0,1])->default(0);
            $table->softDeletes();
            $table->timestamps();
            
            // $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
            // $table->foreign('sub_category_id')->references('id')->on('sub_categories')->cascadeOnDelete();
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
