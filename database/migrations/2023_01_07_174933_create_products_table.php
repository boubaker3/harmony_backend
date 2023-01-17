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
             $table->string("product_name");
            $table->string("product_price");
            $table->string("product_desc",1000);
            $table->longText("product_image");
            $table->string("product_id");
            $table->string("userid");
            $table->float("rating");
            $table->string("oneStar")->default("0");
            $table->string("twoStars")->default("0");
            $table->string("threeStars")->default("0");
            $table->string("fourStars")->default("0");
            $table->string("fiveStars")->default("0");
            $table->timestamp("created_at")->nullable();
            $table->timestamp("updated_at")->nullable();

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
