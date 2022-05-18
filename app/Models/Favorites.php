<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favorites extends Model
{
    use HasFactory;

     /**
     * defining DB relationships
     *
     * @return void
     */
   /* public function recruiters() {
        return $this-> HasMany('App\Models\Recuiters');
    }

    public function developers() {
        return $this-> HasMany('App\Models\Developers');
    }*/


    public function users() {
        return $this->belongsToMany(Users::class);
    }

    public function developers() {
        return $this->hasManyThrough(
            Developers::class,
            Users::class,
            'developer_user_id',
            'id',
            'id',
            'id');
    }
}
