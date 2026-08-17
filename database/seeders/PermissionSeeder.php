<?php

namespace Database\Seeders;

use App\Models\Core\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissionsConfig = config('permissions');

        $flat = [];
        foreach ($permissionsConfig as $group) {
            foreach ($group as $name => $desc) {
                $flat[$name] = $desc;
            }
        }

        foreach ($flat as $name => $description) {
            Permission::updateOrCreate(['name' => $name], ['description' => $description]);
        }

        // Default assignment: Owner gets all permissions
        $ownerRoleId = DB::table('roles')->where('name', 'Owner')->value('id');
        if ($ownerRoleId) {
            $permissionIds = Permission::pluck('id')->toArray();
            foreach ($permissionIds as $pid) {
                DB::table('role_permissions')->updateOrInsert([
                    'role_id' => $ownerRoleId,
                    'permission_id' => $pid,
                ], ['created_at' => now(), 'updated_at' => now()]);
            }
        }
    }
}
