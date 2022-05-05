<?php

namespace Database\Factories;

use App\Models\users;
use Illuminate\Database\Eloquent\Factories\Factory;

class usersFactory extends Factory
{
    protected $model = users::class;

    public function definition(): array
    {
    	return [
    	    //
            'lastname' => $this->faker->lastName,
            'firstname' => $this->faker->firstName,
            'email_address' => $this->faker->safeEmail,
            'password' => $this->faker->password,
            'phone' => $this->faker->phoneNumber,
            // 'dev_id' => $this->faker->randomDigit,
            // 'recrut_id' => $this->randomDigit,
            'subscribe_to_push_notif' => $this->faker->boolean,
            'profile_picture' => $this->faker->url,
    	];
    }
}
