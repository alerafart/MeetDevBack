<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favorites extends Model
{
    use HasFactory;

    public function recruiters() {
        return $this-> belongsTo('App\Models\Recuiters');
    }
}
