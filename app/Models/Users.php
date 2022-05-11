<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

     /**
     * defining DB relationships
     *
     * @return void
     */
    public function recruiters() {
        return $this->hasOne( "App\Models\Recruiter" );
    }

    public function developers() {
        return $this->hasOne( "App\Models\Developers" );
    }

    public function favorites() {
        return $this->hasMany( "App\Models\Favorites" );
    }

    public function messages() {
        return $this->hasMany( "App\Models\Messages" );
    }




    //public function
}
