<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //下記コードを記述しましょう。
        DB::table('posts')->insert([
            ['user_id' => '1',
            'post' => 'Atlas一郎が書いた本',
            ],
            ['user_id' => '2',
            'post' => 'Atlas二郎が書いた本',
            ],
            ['user_id' => '3',
            'post' => 'Atlas三郎が書いた本',
            ],
            ['user_id' => '4',
            'post' => 'Atlas四郎が書いた本',
            ],
            ['user_id' => '5',
            'post' => 'Atlas五郎が書いた本',
            ]
        ]);
    }
}
