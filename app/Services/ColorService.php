<?php


namespace App\Services;

use Faker\Factory;

class ColorService
{
    public static function generateColor(): string
    {
        $faker = Factory::create();

        $colors = ['red', 'yellow', 'green', 'blue', 'indigo', 'purple', 'pink'];

        $color = $faker->randomElement($colors);
        $textWeight = 800;
        $bgWeight = 100;

        return 'text-' . $color . '-' . $textWeight . ' ' . 'bg-' . $color . '-' . $bgWeight;
    }
}
