<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            MathesSeeder::class,
            PermissionRoleTableSeeder::class ,
            PlayersTableSeeder::class,
            ActivitiesTableSeeder::class,
            TransactionsTableSeeder::class,
//            BookingsTableSeeder::class,
        ]);
    }
}
