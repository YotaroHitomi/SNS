<?php

namespace Database\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // UsersTableSeederを呼び出し
        $this->call(UsersTableSeeder::class);

        // PostsTableSeederを呼び出し
        $this->call(PostsTableSeeder::class);
    }
}
