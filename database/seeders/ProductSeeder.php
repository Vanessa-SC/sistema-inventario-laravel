<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Image;
use App\Models\Entradas;
use App\Models\Salidas;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        $productos = Product::factory(16)->create();

        foreach ($productos as $producto){
            // Image::factory(1)->create([
            //     'imageable_id' => $producto->id,
            //     'imageable_type' => Product::class
            // ]);

            Entradas::factory(1)->create([
                'cantidad' => $producto->stock_inicial,
                'precio' => $producto->precio_publico,
                'product_id' => $producto->id
            ]);
        }
    }
}
