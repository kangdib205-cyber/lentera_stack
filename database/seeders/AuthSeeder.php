<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure default roles
        $roles = ['Owner', 'Manager', 'Cashier', 'Kitchen'];
        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(['name' => $role], ['name' => $role]);
        }

        if (User::count() === 0) {
            $user = User::create([
                'name' => 'Owner',
                'email' => 'owner@example.com',
                'password' => bcrypt('password123'),
                'is_active' => true,
            ]);

            $ownerRoleId = DB::table('roles')->where('name', 'Owner')->value('id');
            if ($ownerRoleId) {
                DB::table('user_roles')->insert(['user_id' => $user->id, 'role_id' => $ownerRoleId, 'created_at' => now(), 'updated_at' => now()]);
            }
        }
    }
}
