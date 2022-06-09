<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Negocio>
 */
class NegocioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->unique()->word(25),
            'direccion' => "CALLE VICTORIA #123",
            'direccion2' => "ZONA CENTRO",
            'ciudad' => "VICTORIA DE DURANGO, DGO.",
            'codigo_postal' => "34000",
            'telefono' => "(618) 111 22 33",
            'email' => "correo@mail.com"
        ];
    }
}
