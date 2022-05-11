<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    public function recruiters() {
        return $this->hasOne( "App\Models\Recruiter" );
    }

    public function developers() {
        return $this->hasOne( "App\Models\Developers" );
    }
}
