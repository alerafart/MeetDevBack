<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;

     /**
     * defining DB relationships
     *
     * @return void
     */
    public function users() {
        return $this->belongsToMany( Users::class, 'receiver_user_id', 'sender_user_id' );
    }
}
