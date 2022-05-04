<?php

namespace Database\Factories;

use App\Models\recruiters;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecruitersFactory extends Factory
{
    protected $model = recruiters::class;

    public function definition(): array
    {
    	return [
    	    'company_name'=>$this->faker->name,
            'needs_description'=>$this->faker->sentences,
            'web_site_link'=>$this->url,
    	];
    }
}
