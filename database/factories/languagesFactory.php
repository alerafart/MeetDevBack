<?php

namespace Database\Factories;

use App\Models\languages;
use Illuminate\Database\Eloquent\Factories\Factory;

class LanguagesFactory extends Factory
{
    protected $model = languages::class;

    public function definition(): array
    {
    	return [
    	    'language_name'=> $this->faker->lastName,
    	];
    }
}
