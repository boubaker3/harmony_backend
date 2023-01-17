<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChefShipperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chef_shipper', function (Blueprint $table) {
            $table->id();
            $table->string("chef_shipper_id");
            $table->string("chef_id");
            $table->string("shipper_id")->unique();
            $table->string("status");
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
        Schema::dropIfExists('chef_shipper');
    }
}
