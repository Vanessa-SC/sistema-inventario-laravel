<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
     function definition()
    {
        return [
            'url' => 'images/' . $this->faker->image('public/storage/images', 640, 480, null, false)
        ];
    }
}
