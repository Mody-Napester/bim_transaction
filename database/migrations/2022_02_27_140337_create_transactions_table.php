<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned(); // Category
            $table->integer('sub_category_id')->unsigned()->nullable(); // Subcategory (Reference Category)
            $table->integer('customer_id')->unsigned(); // Payer
            $table->float('amount'); // Amount
            $table->date('due_date'); // Due on
            $table->float('vat')->default(0); // VAT %
            $table->boolean('is_vat_inclusive')->default(0)->comment('0 for no, 1 for yes'); // Is VAT inclusive (0,1)
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('customer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
