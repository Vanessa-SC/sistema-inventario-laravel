<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proveedore>
 */
class ProveedoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->unique()->name(),
            'direccion' => $this->faker->streetAddress().' '.$this->faker->stateAbbr().' '.$this->faker->postcode(),
            'email' => $this->faker->email(),
            'telefono' => $this->faker->phoneNumber(),
        ];
    }
}
