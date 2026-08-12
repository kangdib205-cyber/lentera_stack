<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pos_sale_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->integer('qty')->default(1);
            $table->decimal('price', 12, 2)->default(0);
            $table->timestamps();

            $table->foreign('sale_id')->references('id')->on('pos_sales')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('pos_products')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pos_sale_items');
    }
};
