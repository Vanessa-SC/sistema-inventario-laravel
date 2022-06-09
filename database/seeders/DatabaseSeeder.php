<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

use App\Models\Category;
use App\Models\Proveedore;
use App\Models\Negocio;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Storage::deleteDirectory('images');
        Storage::makeDirectory('images');

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        Category::factory(10)->create();
        Negocio::factory(1)->create();
        Proveedore::factory(10)->create();
        $this->call(ProductSeeder::class);
    }
}
