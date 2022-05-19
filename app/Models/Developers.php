<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class developers extends Model
{
    use hasFactory;

    /**
     * defining DB relationships
     *
     * @return void
     */
    public function usersRelationship() {
        return $this->belongsTo(Users::class, 'dev_id');
    }

    public function languages() {
        return $this->HasMany('App\Models\Languages', 'dev_lang');
    }


    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'available_for_recruiters' => 1,
        'available_for_developers' => 0,
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
