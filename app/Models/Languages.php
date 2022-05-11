<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Languages extends Model
{
    use HasFactory;

    public function developers() {
        return $this->HasMany('App\Models\Developers');
    }

}
