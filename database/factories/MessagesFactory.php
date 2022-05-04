<?php

namespace Database\Factories;

use App\Models\messages;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessagesFactory extends Factory
{
    protected $model = messages::class;

    public function definition(): array
    {
        $sender=1;
        $receiver=2;

    	return [
    	    'message_content'=>$this->faker->sentence,
            'receiver_user_id'=>$this->$receiver,
            'sender_user_id'=>$this->$sender
    	];
    }
}
