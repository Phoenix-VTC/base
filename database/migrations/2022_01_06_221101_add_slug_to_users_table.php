<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('username');
        });

        User::all()->each(function (User $user) {
            $slug = Str::slug($user->username);
            while (User::whereSlug($slug)->exists()) {
                $slug .= '_'.Str::random(3);
            }
            $user->slug = $slug;
            $user->save();
        });

        User::onlyTrashed()->get()->each(function (User $user) {
            $slug = Str::slug($user->username);
            while (User::whereSlug($slug)->exists()) {
                $slug .= '_'.Str::random(3);
            }
            $user->slug = $slug;
            $user->save();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
