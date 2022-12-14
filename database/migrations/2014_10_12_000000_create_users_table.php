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
            $table->string('name');
            $table->bigInteger('nik');
            $table->string('phone')->unique();
            $table->integer('age');
            $table->string('blood_type');
            $table->integer('role_id')->comment('1 = user, 2 = admin');
            $table->string('image')->nullable();
            $table->string('password');
            $table->boolean('is_pendonor');
            $table->integer('history_donor_count')->default(0);
            $table->string('token_fcm')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
