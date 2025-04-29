<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // 外部キー制約を無効にする
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // usersテーブルのデータを削除
        User::query()->delete(); // 修正箇所

        // Admin User
        $admin = User::create([
            'username' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('away13590022'),
            'profile_image' => 'icon1.png',
        ]);

        // Other Users
        $user1 = User::create([
            'username' => 'User One',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
            'profile_image' => 'icon2.png',
        ]);

        $user2 = User::create([
            'username' => 'User Two',
            'email' => 'user2@example.com',
            'password' => Hash::make('password'),
            'profile_image' => 'icon3.png',
        ]);

        // Create some default follows for users
        $admin->followings()->syncWithoutDetaching([$user1->id, $user2->id]);
        $user1->followings()->syncWithoutDetaching([$admin->id]);
        $user2->followings()->syncWithoutDetaching([$admin->id]);

        // Create some posts for the users
        $admin->posts()->create([
            'post' => 'これはAdmin Userさんの一つ目の投稿です.',
        ]);
        $user1->posts()->create([
            'post' => 'これはUser Oneさんの一つ目の投稿です.',
        ]);
        $user2->posts()->create([
            'post' => 'これはUser Twoさんの一つ目の投稿です.',
        ]);

        // 外部キー制約を再度有効にする
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
