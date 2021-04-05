<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_receipts', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->unsignedBigInteger('order_id');
            $table->string('goodReceiptId');
            $table->unsignedBigInteger('status_id');

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('restrict');
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
        Schema::dropIfExists('good_receipts');
    }
}
