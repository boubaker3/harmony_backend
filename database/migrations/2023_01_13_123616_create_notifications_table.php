<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string("notif_id");
            $table->string("notif_sender");
            $table->string("notif_receiver");
            $table->string("quantity")->nullable();
            $table->string("product_id")->nullable();
            $table->float("rating")->nullable();
            $table->longText("feedback")->nullable() ;
            $table->longText("product_feedback")->nullable();
            $table->float("product_rating")->nullable() ;
            $table->string("type");
            $table->string("status")->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
