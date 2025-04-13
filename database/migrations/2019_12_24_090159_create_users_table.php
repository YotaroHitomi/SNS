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
            $table->string('username')->unique(); // ユーザー名にユニーク制約を追加
            $table->string('mail')->unique(); // メールもユニーク制約を追加
            $table->string('password');
            $table->string('profile_image')->nullable()->default('default-icon.png'); // デフォルト画像を設定
            $table->text('bio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * マイグレーションをロールバックするためのメソッド。
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
