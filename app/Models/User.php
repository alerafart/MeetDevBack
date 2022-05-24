<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use App\Http\Traits\MustVerifyEmail as MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authorizable, Notifiable, Authenticatable, MustVerifyEmail;

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
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    public function routeNotificationForMail($notification)
    {
        // Return email address only...
        return $this->email_address;

        // Return email address and name...
       // return [$this->email_address => $this->name];
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email_address', 'password', 'lastname', 'firstname', 'city', 'department', 'zip_code', 'phone', 'subscribe_to_push_notif', 'profile_picture', 'company_name', 'needs_description', 'web_site_link'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
       // 'password',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {/**
        * If user email have changed email verification is required
        */
        if( $model->isDirty('email') ) {
            $model->setAttribute('email_verified_at', null);
            $model->sendEmailVerificationNotification();
        }});
    }

}
