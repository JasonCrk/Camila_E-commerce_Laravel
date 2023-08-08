<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $connection = config('database.default');
        $roleModel = app(config('permission.models.role'));

        $roles = [
            'admin',
            'user'
        ];

        foreach ($roles as $role) {
            $roleModel::on($connection)->create(['name' => $role]);
        }
    }
}
