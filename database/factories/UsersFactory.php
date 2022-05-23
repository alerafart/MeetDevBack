<?php

namespace Database\Factories;

use Faker\Generator;
use App\Models\users;
use App\Models\Developers;
use Faker\Provider\fr_FR\Address;
use Tymon\JWTAuth\Providers\JWT\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;
// $faker = Faker\Factory::create();
// $faker = new Faker\Generator();
class UsersFactory extends Factory
{

    /* Schema::create('matches', function (Blueprint $table) {
        ...
        $table->integer('home_user_id')->unsigned();
        $table->foreign('home_user_id')->references('id')->on('users');
        $table->integer('away_user_id')->unsigned();
        $table->foreign('away_user_id')->references('id')->on('users');
        ...
    } */
    protected $model = Users::class;


    public function definition(): array
    {

    	return [
    	    //
            'lastname' => $this->faker->lastName,
            'firstname' => $this->faker->firstName,
            'city' => $this->faker->city,
            // 'department'=> $this->faker->department,
            // 'zip_code'=> $this->faker->zip_code,
            'email_address' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'password' => $this->faker->password,
            'dev_id' => Developers::pluck('id')->random(),
            //'dev_id' => $this->faker->foreignId('dev_id')->references('id')->on('developers'),
            //'recrut_id' => $this->faker->foreignId('recrut_id')->references('id')->on('recruiters'),
            // 'recrut_id' => $this->randomDigit,
            'subscribe_to_push_notif' => $this->faker->randomElement([1, 2]),
            // 'email_verified_at'=> $this->faker->timestamp(),
            'profile_picture' => $this->faker->url,
    	];
    }
}
