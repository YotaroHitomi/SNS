<?php

namespace Database\Seeds;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // usersテーブルのデータを初期化（削除）
        User::truncate(); // または DB::table('users')->truncate();

        // Admin User
        $admin = User::create([
            'username' => 'Admin User',
            'mail' => 'admin@example.com',
            'password' => Hash::make('away13590022'),
            'profile_image' => 'icon1.png',
        ]);

        // Other Users
        $user1 = User::create([
            'username' => 'User One',
            'mail' => 'user1@example.com',
            'password' => Hash::make('password'),
            'profile_image' => 'icon2.png',
        ]);

        $user2 = User::create([
            'username' => 'User Two',
            'mail' => 'user2@example.com',
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
    }
}
