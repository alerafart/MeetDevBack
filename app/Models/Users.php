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
}
