<?php


namespace App\Services;

use Faker\Factory;

class ColorService
{
    public static function generateColor(): string
    {
        $faker = Factory::create();

        $weights = [300, 400, 500];
        $colors = ['red', 'yellow', 'green', 'blue', 'indigo', 'purple', 'pink'];

        return $faker->randomElement($colors) . '-' . $faker->randomElement($weights);
    }
}
