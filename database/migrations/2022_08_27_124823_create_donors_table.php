<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->bigInteger('nik');
            $table->string('ttl');
            $table->string('address');
            $table->string('city');
            $table->string('phone');
            $table->tinyInteger('status')->comment('0 : menunggu, 1 : disetujui, -1 : ditolak');
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
        Schema::dropIfExists('donors');
    }
}
