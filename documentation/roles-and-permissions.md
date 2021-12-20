# Managing roles & permissions
Previously, all roles, permissions and role permissions were managed with migrations. This is replaced by the `RolesAndPermissionsSeeder`, so migrations should no longer be used to manage these.
This document explains the usage of this seeder.

## Creating a new role
To create a new role, simply add a new item to the `$roleList` array in the `RolesAndPermissionsSeeder.php`. For example:
```php
$roleList = [
    'identifier' => [
        'name' => 'permission name',
        'badge_color' => '#f48c06',
        'text_color' => '#ffffff',
        'level' => 1,
    ],
    ...
];
```

### Required fields
**Identifier:** This will be used to create or update the role. Don't change it after creating, or you'll end up with duplicate roles. If you do edit it though, make sure to manually fix the duplicates. This field isn't used for any other purpose currently.
**Badge color:** The HEX code to be used as the level's badge background color.
**Text color:** The HEX code to be used as the level's text color.
**Level:** The level of the role, to specify it's importance/rank. Higher = more important, must be a value between **1** (lowest) and **255** (highest).

## Modifying a role
You can easily modify every part of a role by simply editing its row in the aray, and it'll be updated whenever you run the seeder. Just keep in mind to not change the `identifier`, otherwise you will end up with duplicates that you'll manually need to fix.

### Renaming a role
Roles can be renamed without any issues, just make sure to not rename the `identifier` (see above).

### Deleting a role
In order to delete a role, simply remove its row from the `$roleList` array, and run the seeder.

## Creating a new permission
To create a new permission, simply add a new item to the `$permissionList` array in the `RolesAndPermissionsSeeder.php`. For example:
```php
$permissionList = [
    'permission name',
    ...
];
```

### Required fields
**Permission name:** This will be used to find or create the role in the DB. Spaces are allowed, e.g. "update users"

## Modifying a permission
### Renaming a permission
Permissions are found or created by their `name` field, so renaming it will result in the permission being recreated with its new name. The permission with the old name will then also be removed, since it will/should no longer exist in the `$permissionList` array. Just keep in mind to update all entries in the `assignPermissionsToRoles` function.

### Deleting a permission
In order to delete a permission, simply remove its row from the `$roleList` array, and run the seeder.

## Assigning permissions to a role
Assigning permissions to a role is quite easy. Every key in the `$this->roles` array (aka `$roles`) is a `Spatie\Permission\Models\Role` object. That means that in the `assignPermissionsToRoles` function, we can simply do:
```php
$roles['role name']->givePermissionTo([
    $permissions['permission name'],
    $permissions['another permission'],
    ...
]);
```
The names of the available permissions here are defined in the `$permissionList` array.
