<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Profile;
use App\Models\User;
use App\Models\WhishList;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'username' => 'Admin',
            'first_name' => 'admin_first_name',
            'last_name' => 'admin_last_name',
            'phone_number' => fake()->unique()->numerify('###-###-###'),
            'email' => 'admin@gmail.com',
            'password' => 'adminpassword'
        ])->assignRole('admin');

        Profile::create([
            'user_id' => $user->id
        ]);

        Cart::create([
            'user_id' => $user->id
        ]);

        WhishList::create([
            'user_id' => $user->id
        ]);
    }
}
