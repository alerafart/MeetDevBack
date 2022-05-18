<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function developersRelationship() {
        return $this->hasOne( "App\Models\Developers" );
    }

    public function getDevelopersAttribute(){
        return $this->developersRelationship()->dev_id;
    }

    public function favorites() {
        return $this->beslongsToMany( "App\Models\Favorites" );
    }

    public function messages() {
        return $this->hasMany( "App\Models\Messages" );
    }
}
