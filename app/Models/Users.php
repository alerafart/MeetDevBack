<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Laravel\Lumen\Auth\Authorizable;

//use Illuminate\Foundation\Auth\Users as Authenticatable;


class Users extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasFactory, Notifiable, Authenticatable, Authorizable;

    /**
     * defining DB relationships
     *
     * @return void
     */
    public function recruiters() {
        return $this->hasOne( Recruiters::class );
    }

    public function developers() {
        return $this->hasOne( Developers::class, 'id' );
    }

    /*public function getDevelopersAttribute(){
        return $this->developersRelationship()->dev_id;
    }*/

    public function favorites() {
        return $this->belongsToMany( Favorites::class, 'developer_user_id', 'recruiter_user_id' );
    }

    public function messages() {
        return $this->hasMany( Messages::class );
    }


    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'subscribe_to_push_notif' => 0,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lastname', 'firstname', 'city', 'department', 'zip_code', 'email_address', 'phone', 'password', 'subscribe_to_push_notif', 'profile_picture'
    ];

}
