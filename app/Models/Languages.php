<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Languages extends Model
{
    use HasFactory;

<<<<<<< HEAD
     /**
     * defining DB relationships
     *
     * @return void
     */
    public function developers() {
        return $this->HasMany('App\Models\Developers', 'dev_lang');
=======
    public function developers() {
        return $this->HasMany('App\Models\Developers');
>>>>>>> 8623d7342f05b94ab4acdef34669ede0f715720c
    }

}
