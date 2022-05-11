<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recruiters extends Model
{
    use HasFactory;

    public function favorites() {
            return $this->hasMany( "App\Models\Favorites" );
    }

    public function messages() {
        return $this->hasMany( "App\Models\Messages" );
    }

    public function users() {
        return $this->hasOne(Users::class);
    }
}
