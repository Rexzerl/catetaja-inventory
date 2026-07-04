<?php

namespace Database\Seeders;

use App\Models\User;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Elektronik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alat Tulis Kantor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Furnitur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Perangkat Jaringan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lainnya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }

}
