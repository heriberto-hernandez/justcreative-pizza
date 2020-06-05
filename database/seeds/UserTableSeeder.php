<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Heriberto Hernandez',
            'email' => 'hernandezcastell28@gmail.com',
            'password' => Hash::make('admin-pizza'),
        ]);
        $admin->roles()->attach(Role::where('name', 'admin')->first());

        $personnel = User::create([
            'name' => 'Heriberto Hernandez',
            'email' => 'hernandezcastell8@gmail.com',
            'password' => Hash::make('pizza-pizza'),
        ]);
        $personnel->roles()->attach(Role::where('name', 'personnel')->first());
    }
}
