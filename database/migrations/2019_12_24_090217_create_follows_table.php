<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
    /**
     * マイグレーション実行のためのメソッド。
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->bigIncrements('id'); // auto_incrementでIDカラムを作成
            $table->unsignedBigInteger('following_id'); // following_idカラム（unsignedBigInteger型）
            $table->unsignedBigInteger('followed_id'); // followed_idカラム（unsignedBigInteger型）
            $table->timestamps(0); // created_at、updated_atカラムを追加（timestamp型）

            // 外部キー制約を設定
            $table->foreign('following_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('followed_id')->references('id')->on('users')->onDelete('cascade');

            // following_id と followed_id の組み合わせを一意にする（同じユーザーが他のユーザーを複数回フォローしないように）
            $table->unique(['following_id', 'followed_id']);
        });
    }

    /**
     * マイグレーションをロールバックするためのメソッド。
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follows');
    }
}
