<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'name' => $this->faker->name,
            // 'email' => $this->faker->unique()->safeEmail,
            'lastname' => $this->faker->lastName,
            'firstname' => $this->faker->firstName,
            'email_address' => $this->faker->safeEmail,
            'password' => $this->faker->password,
            'phone' => $this->faker->phoneNumber,
            'dev_id' => $this->faker->randomDigit,
            'recrut_id'  => $this->null,
            'subscribe_to_push_notif' => $this->faker->boolean,
            'profile_picture' => $this->faker->url,
        ];
    }
}
