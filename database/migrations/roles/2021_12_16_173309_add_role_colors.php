<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class AddRoleColors extends Migration
{
     private array $roleColors = [
        'super admin' => ['#f3e8ff', '#6b21a8'],
        'management' => ['#df012f', '#ffffff'],
        'human resources' => ['#a30000', '#ffffff'],
        'events' => ['#a30000', '#ffffff'],
        'media' => ['#a30000', '#ffffff'],
        'modding' => ['#a30000', '#ffffff'],
        'driver' => ['#f48c06', '#ffffff'],
        'beta tester' => ['#fbd19b', '#000000'],
        'phoenix staff' => ['#a30000', '#ffffff'],
        'early bird' => ['#3498db', '#ffffff'],
        'developer' => ['#a30000', '#ffffff'],
    ];

    public function up()
    {
        foreach ($this->roleColors as $role => $colors) {
            $role = Role::findByName($role);
            $role->badge_color = $colors[0];
            $role->text_color = $colors[1];
            $role->save();
        }
    }

    public function down()
    {
        foreach ($this->roleColors as $role => $color) {
            $role = Role::findByName($role);
            $role->badge_color = '#f4f5f7';
            $role->text_color = '#1f2937';
            $role->save();
        }
    }
}
