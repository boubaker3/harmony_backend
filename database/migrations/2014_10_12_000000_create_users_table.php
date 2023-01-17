<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("userid");
            $table->string("email");
            $table->string("password");
            $table->string("remember_token",500);
            $table->string("city");
            $table->string("country");
            $table->string("address");
            $table->string("phone");
            $table->longText("photo");
            $table->longText("cover");
            $table->float("rating");
            $table->string("bio");
            $table->string("type");
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
        Schema::dropIfExists('users');
    }
}
