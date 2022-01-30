<?php

namespace Database\Seeders;

use App\Models\Blocklist;
use Illuminate\Database\Seeder;

class BlocklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Blocklist::factory(100)->create();
    }
}
