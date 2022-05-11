<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class developers extends Model
{
    use hasFactory;

<<<<<<< HEAD
    /**
     * defining DB relationships
     *
     * @return void
     */
    public function users() {
        return $this->hasOne(Users::class);
    }

    public function languages() {
        return $this->HasMany('App\Models\Languages', 'dev_lang');
    }


=======
    public function users()
    {
        return $this->hasOne(Users::class);
    }
>>>>>>> 8623d7342f05b94ab4acdef34669ede0f715720c
}
