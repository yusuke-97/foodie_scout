<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::factory(50)->create();

        $myAccount = \App\Models\User::firstOrCreate(
            ['email' => 'tigersyuu7@gmail.com'],
            [
                'name' => '石山 優友',
                'user_name' => 'Yusuke_97',
                'phone_number' => '000-0000-0000',
                'email_verified_at' => now(),
                'password' => bcrypt('$2y$10$x/wIGhoxtFoU7m0IG0UCM.LZ4rURh0D060AIVvn49ley6Hrcqk/j6'),
                'remember_token' => Str::random(10),
            ]
        );

        $firstUser = $myAccount;

        $otherUsers = $users;

        foreach ($otherUsers as $user) {
            $firstUser->follow($user);
            $user->follow($firstUser);
        }
    }
}
