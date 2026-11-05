<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $outlet = Outlet::create([
            'name'    => 'Laundry Pusat',
            'address' => 'Jl. Mawar No. 1',
            'phone'   => '021-1234567',
        ]);

        $super = User::create([
            'name'     => 'Super Admin',
            'email'    => 'super@laundry.test',
            'password' => Hash::make('password'),
        ]);
        $super->forceFill([
            'role'              => User::ROLE_SUPER_ADMIN,
            'email_verified_at' => now(),
        ])->save();

        $admin = User::create([
            'name'     => 'Admin Pusat',
            'email'    => 'admin@laundry.test',
            'password' => Hash::make('password'),
        ]);
        $admin->forceFill([
            'role'              => User::ROLE_ADMIN,
            'outlet_id'         => $outlet->id,
            'email_verified_at' => now(),
        ])->save();

        $user = User::create([
            'name'     => 'Pelanggan',
            'email'    => 'user@laundry.test',
            'password' => Hash::make('password'),
        ]);
        $user->forceFill([
            'role'              => User::ROLE_USER,
            'email_verified_at' => now(),
        ])->save();
    }
}