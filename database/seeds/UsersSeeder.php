<?php

use App\Entities\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Andrew',
                'email' => 'admin@admin.me',
                'password' => 'secret'
            ]
        ];

        array_map([$this, 'createUsers'], $users);
    }

    public function createUsers($user)
    {
        User::create($user);
    }
}
