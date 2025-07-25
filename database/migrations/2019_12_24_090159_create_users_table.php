<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * マイグレーション実行のためのメソッド。
     *
     * @return void
     */
public function up()
{
  Schema::create('users', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('username',255);
    $table->string('mail',255);
    $table->string('password',255);
    $table->string('bio',400)->nullable();
    $table->string('images',255)->default('icon1.png');
    $table->timestamp('created_at')->useCurrent();
    $table->timestamp('updated_at')->default(DB::raw('current_timestamp on update current_timestamp'));
  });
}



    /**
     * マイグレーションをロールバックするためのメソッド。
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users'); // usersテーブルの削除
    }
}
