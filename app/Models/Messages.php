<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;

<<<<<<< HEAD
     /**
     * defining DB relationships
     *
     * @return void
     */
    public function users() {
        return $this->HasMany('App\Models\Users');
=======
    public function recruiters() {
        return $this->HasMany('App\Models\Recuiters');
>>>>>>> 8623d7342f05b94ab4acdef34669ede0f715720c
    }
}
