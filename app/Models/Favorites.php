<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favorites extends Model
{
    use HasFactory;

<<<<<<< HEAD
     /**
     * defining DB relationships
     *
     * @return void
     */
   /* public function recruiters() {
=======
    public function recruiters() {
>>>>>>> 8623d7342f05b94ab4acdef34669ede0f715720c
        return $this-> HasMany('App\Models\Recuiters');
    }

    public function developers() {
        return $this-> HasMany('App\Models\Developers');
<<<<<<< HEAD
    }*/

    public function users() {
        return $this->HasMany('App\Models\Users');
=======
>>>>>>> 8623d7342f05b94ab4acdef34669ede0f715720c
    }
}
