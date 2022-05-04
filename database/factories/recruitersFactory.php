<?php

namespace Database\Factories;

use App\Models\recruiters;
use Illuminate\Database\Eloquent\Factories\Factory;

class recruitersFactory extends Factory
{
    protected $model = recruiters::class;

    public function definition(): array
    {
    	return [
    	    'company_name'=>$this->faker->name,
            'needs_description'=>$this->faker->sentence,
            'web_site_link'=>$this->url,
    	];
    }
}
