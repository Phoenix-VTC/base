<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    private array $permissions = [];
    private array $roles = [];

    /**
     * This seeder seeds all defined roles, permissions and role permissions.
     * For more information about its usage, please refer to the documentation (documentation\roles-and-permissions.md).
     *
     * @return void
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->seedRoles();
        $this->seedPermissions();
        $this->assignPermissionsToRoles();
    }

    private function seedRoles(): void
    {
        // The array of roles to be seeded
        $roleList = [
            'driver' => [
                'name' => 'driver',
                'badge_color' => '#f48c06',
                'text_color' => '#ffffff',
                'level' => 1,
            ],
            'early_bird' => [
                'name' => 'early bird',
                'badge_color' => '#3498db',
                'text_color' => '#ffffff',
                'level' => 1,
            ],
            'beta_tester' => [
                'name' => 'beta tester',
                'badge_color' => '#fbd19b',
                'text_color' => '#000000',
                'level' => 1,
            ],
            'phoenix_staff' => [
                'name' => 'phoenix staff',
                'badge_color' => '#a30000',
                'text_color' => '#ffffff',
                'level' => 2,
                'is_staff' => true,
            ],
            'modding_team' => [
                'name' => 'modding team',
                'badge_color' => '#a30000',
                'text_color' => '#ffffff',
                'level' => 3,
                'is_staff' => true,
            ],
            'media_team' => [
                'name' => 'media team',
                'badge_color' => '#a30000',
                'text_color' => '#ffffff',
                'level' => 4,
                'is_staff' => true,
            ],
            'recruitment_team' => [
                'name' => 'recruitment team',
                'badge_color' => '#a30000',
                'text_color' => '#ffffff',
                'level' => 5,
                'is_staff' => true,
            ],
            'event_team' => [
                'name' => 'event team',
                'badge_color' => '#a30000',
                'text_color' => '#ffffff',
                'level' => 6,
                'is_staff' => true,
            ],
            'human_resources_team' => [
                'name' => 'human resources team',
                'badge_color' => '#a30000',
                'text_color' => '#ffffff',
                'level' => 7,
                'is_staff' => true,
            ],
            'developer' => [
                'name' => 'developer',
                'badge_color' => '#a30000',
                'text_color' => '#ffffff',
                'level' => 8,
                'is_staff' => true,
            ],
            'senior_staff_team' => [
                'name' => 'senior staff team',
                'badge_color' => '#c10118',
                'text_color' => '#ffffff',
                'level' => 9,
                'is_staff' => true,
            ],
            'manager' => [
                'name' => 'manager',
                'badge_color' => '#df012f',
                'text_color' => '#ffffff',
                'level' => 10,
                'is_staff' => true,
                'is_upper_staff' => true,
            ],
            'super_admin' => [
                'name' => 'super admin',
                'badge_color' => '#f3e8ff',
                'text_color' => '#6b21a',
                'level' => 255,
                'is_staff' => true,
                'is_upper_staff' => true,
            ],
        ];

        foreach ($roleList as $identifier => $role) {
            // Create or update the role, and assign it to the array of roles
            $this->roles[$role['name']] = Role::query()->updateOrCreate([
                'identifier' => $identifier,
            ], $role);
        }

        // Delete all roles that are not in the array of roles
        Role::query()->whereNotIn('identifier', array_keys($roleList))->delete();
    }

    private function seedPermissions(): void
    {
        // The array of permissions to be seeded
        $permissionList = [
            'handle driver applications',
            'manage users',
            'delete users',
            'manage vacation requests',
            'manage events',
            'use switch',
            'manage game data',
            'beta test',
            'submit jobs',
            'manage downloads',
            'manage driver inactivity',
            'impersonate users',
            'view blocklist',
            'create blocklist',
            'delete blocklist',
            'manage screenshots',
        ];

        foreach ($permissionList as $permission) {
            // Create or update the permission, and assign it to the array of permissions
            $this->permissions[$permission] = Permission::query()->firstOrCreate([
                'name' => $permission,
            ]);
        }

        // Delete all permissions that are not in the array of permissions
        Permission::query()->whereNotIn('name', $permissionList)->delete();
    }

    private function assignPermissionsToRoles(): void
    {
        $roles = $this->roles;
        $permissions = $this->permissions;

        $roles['manager']->syncPermissions([
            $permissions['handle driver applications'],
            $permissions['manage users'],
            $permissions['delete users'],
            $permissions['manage vacation requests'],
            $permissions['manage events'],
            $permissions['use switch'],
            $permissions['manage game data'],
            $permissions['beta test'],
            $permissions['submit jobs'],
            $permissions['manage downloads'],
            $permissions['manage driver inactivity'],
            $permissions['impersonate users'],
            $permissions['view blocklist'],
            $permissions['create blocklist'],
            $permissions['delete blocklist'],
            $permissions['manage screenshots'],
        ]);

        $roles['developer']->syncPermissions([
            $permissions['manage users'],
            $permissions['impersonate users'],
        ]);

        $roles['human resources team']->syncPermissions([
            $permissions['handle driver applications'],
            $permissions['manage users'],
            $permissions['delete users'],
            $permissions['manage vacation requests'],
            $permissions['manage driver inactivity'],
            $permissions['view blocklist'],
            $permissions['create blocklist'],
            $permissions['manage screenshots'],
        ]);

        $roles['event team']->syncPermissions([
            $permissions['manage events'],
        ]);

        $roles['driver']->syncPermissions([
            $permissions['submit jobs'],
        ]);

        $roles['beta tester']->syncPermissions([
            $permissions['use switch'],
            $permissions['beta test'],
        ]);
    }
}
