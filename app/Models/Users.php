<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class Users extends Model implements JWTSubject
{
    use HasFactory, Authenticatable, Authorizable; //Notifiable;


    /**
    * Get the identifier that will be stored in the subject claim of the JWT.
    *
    * @return mixed
    */
   public function getJWTIdentifier()
   {
       return $this->getKey();
   }

   /**
    * Return a key value array, containing any custom claims to be added to the JWT.
    *
    * @return array
    */
   public function getJWTCustomClaims()
   {
       return [];
   }



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
}
