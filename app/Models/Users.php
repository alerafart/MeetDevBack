<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

<<<<<<< HEAD
     /**
     * defining DB relationships
     *
     * @return void
     */
=======
>>>>>>> 8623d7342f05b94ab4acdef34669ede0f715720c
    public function recruiters() {
        return $this->hasOne( "App\Models\Recruiter" );
    }

    public function developers() {
        return $this->hasOne( "App\Models\Developers" );
    }
<<<<<<< HEAD

    public function favorites() {
        return $this->hasMany( "App\Models\Favorites" );
    }

    public function messages() {
        return $this->hasMany( "App\Models\Messages" );
    }
=======
>>>>>>> 8623d7342f05b94ab4acdef34669ede0f715720c
}
