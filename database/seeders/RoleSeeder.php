<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->upsert([
            ['id' => 1, 'name' => 'estudiante'],
            ['id' => 2, 'name' => 'profesor'],
            ['id' => 3, 'name' => 'admin'],
        ], ['id'], ['name']);
    }
}
