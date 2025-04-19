<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 外部キー制約を無効にする
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 投稿データを挿入
        $users = User::all();  // 全ユーザーを取得

        foreach ($users as $user) {
            // ユーザーがフォローしているユーザーに対してデフォルト投稿を作成
            foreach ($user->followings as $followedUser) {
                // 同じ投稿がすでに存在するか確認
                if (Post::where('user_id', $followedUser->id)->where('post', 'このユーザーはフォローされていますが、まだ投稿をしていません。')->doesntExist()) {
                    Post::create([
                        'user_id' => $followedUser->id,  // フォローされているユーザーのID
                        'post' => 'このユーザーはフォローされていますが、まだ投稿をしていません。',
                    ]);
                }
            }
        }

        // 外部キー制約を再度有効にする
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
