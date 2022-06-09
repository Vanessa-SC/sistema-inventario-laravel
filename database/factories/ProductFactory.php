<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\User;
use App\Models\Proveedore;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        
        $stock = $this->faker->randomDigit();
        $precio = $this->faker->randomFloat(2,5, 100);
        return [
            'codigo' => $this->faker->ean13(),
            'descripcion' => $this->faker->sentence(3),
            'stock_inicial' => $stock,
            'existencias' => $stock,
            'precio_proveedor' => $precio,
            'precio_publico' => $this->faker->randomFloat(2,$precio, $precio*2),
            'formato_venta' => 'pieza',
            'marca' => 'Sin marca',
            'proveedore_id' => Proveedore::all()->random()->id,
            'category_id' => Category::all()->random()->id,
        ];
    }
}
