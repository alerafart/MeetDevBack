<?php

namespace Database\Factories;

use App\Models\developers;
use Illuminate\Database\Eloquent\Factories\Factory;

class DevelopersFactory extends Factory
{
    protected $model = developers::class;

    public function definition(): array
    {
    	return [
    	    'description'=> $this->faker->sentence,
            'available_for_recruiters' => $this->false,
            'available_for_developers' => $this->true,
            'minimum_salary_requested' => $this->faker->randomNumber,
            'maximum_salary_requested' => $this->faker->randomNumber,
            'age' => $this->faker->randomDigit,
            'years_of_experience' => $this->faker->randomDigit,
            'github_link' => $this->faker->url,
            'portfolio_link' => $this->faker->url,
            'other_link' => $this->faker->url,
    	];
    }
}
