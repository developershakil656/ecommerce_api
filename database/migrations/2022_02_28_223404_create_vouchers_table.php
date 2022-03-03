<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['flat','percent'])->default('flat');
            $table->string('code');
            $table->decimal('value');
            $table->decimal('minimum_order_value')->nullable();
            $table->decimal('maximum_discount_value')->nullable();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->integer('limit')->nullable();
            $table->string('for')->nullable()->comment('one day or 1 week etc.');
            $table->integer('user_limit')->nullable();
            $table->enum('user_type',['new','existing','all'])->default('all');
            $table->text('only_for_users')->nullable();
            $table->integer('total_used')->nullable();
            $table->string('details')->nullable();
            $table->enum('status',['active','inactive'])->default('inactive');
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
        Schema::dropIfExists('vouchers');
    }
}
