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
     * This seeder seeds all defined roles and permissions.
     * If a certain role or permission needs to be changed/added, simply change it here, and it'll be updated on the next run.
     * Just keep in mind that it uses the name of the role/permission as the search key, so if you change the name of the role/permission, you'll need to update some things manually.
     *
     * Note from me (Diego):
     * I'm pretty proud of this seeder lmao. I wanted to find an efficient way to manage permissions and roles,
     * since I never really found a good way to implement role & permission seeding yet, without manually having to create them on every environment.
     * This seems to limit code duplication better than any other solution I've seen so far, so I see it as a win!
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
                'badge_color' => '#f48c06',
                'text_color' => '#ffffff',
                'level' => 1,
            ],
            'early bird' => [
                'badge_color' => '#3498db',
                'text_color' => '#ffffff',
                'level' => 1,
            ],
            'beta tester' => [
                'badge_color' => '#fbd19b',
                'text_color' => '#000000',
                'level' => 1,
            ],
            'phoenix staff' => [
                'badge_color' => '#a30000',
                'text_color' => '#ffffff',
                'level' => 2,
                'is_staff' => true,
            ],
            'modding team' => [
                'badge_color' => '#a30000',
                'text_color' => '#ffffff',
                'level' => 3,
                'is_staff' => true,
            ],
            'media team' => [
                'badge_color' => '#a30000',
                'text_color' => '#ffffff',
                'level' => 4,
                'is_staff' => true,
            ],
            'recruitment team' => [
                'badge_color' => '#a30000',
                'text_color' => '#ffffff',
                'level' => 5,
                'is_staff' => true,
            ],
            'event team' => [
                'badge_color' => '#a30000',
                'text_color' => '#ffffff',
                'level' => 6,
                'is_staff' => true,
            ],
            'human resources team' => [
                'badge_color' => '#a30000',
                'text_color' => '#ffffff',
                'level' => 7,
                'is_staff' => true,
            ],
            'developer' => [
                'badge_color' => '#a30000',
                'text_color' => '#ffffff',
                'level' => 8,
                'is_staff' => true,
            ],
            'senior staff team' => [
                'badge_color' => '#c10118',
                'text_color' => '#ffffff',
                'level' => 9,
                'is_staff' => true,
            ],
            'manager' => [
                'badge_color' => '#df012f',
                'text_color' => '#ffffff',
                'level' => 10,
                'is_staff' => true,
                'is_upper_staff' => true,
            ],
            'super admin' => [
                'badge_color' => '#f3e8ff',
                'text_color' => '#6b21a',
                'level' => 255,
                'is_staff' => true,
                'is_upper_staff' => true,
            ],
        ];

        foreach ($roleList as $name => $role) {
            // Create or update the role, and assign it to the array of roles
            $this->roles[$name] = Role::query()->updateOrCreate([
                'name' => $name,
            ], $role);
        }
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
        ];

        foreach ($permissionList as $permission) {
            // Create or update the permission, and assign it to the array of permissions
            $this->permissions[$permission] = Permission::query()->firstOrCreate([
                'name' => $permission,
            ]);
        }
    }

    private function assignPermissionsToRoles(): void
    {
        $roles = $this->roles;
        $permissions = $this->permissions;

        $roles['manager']->givePermissionTo([
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
        ]);

        $roles['developer']->givePermissionTo([
            $permissions['manage users'],
            $permissions['impersonate users'],
        ]);

        $roles['human resources team']->givePermissionTo([
            $permissions['handle driver applications'],
            $permissions['manage users'],
            $permissions['delete users'],
            $permissions['manage vacation requests'],
            $permissions['manage driver inactivity'],
            $permissions['view blocklist'],
            $permissions['create blocklist'],
        ]);

        $roles['event team']->givePermissionTo([
            $permissions['manage events'],
        ]);

        $roles['driver']->givePermissionTo([
            $permissions['submit jobs'],
        ]);

        $roles['beta tester']->givePermissionTo([
            $permissions['use switch'],
            $permissions['beta test'],
        ]);
    }
}
