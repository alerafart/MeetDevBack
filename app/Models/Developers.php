<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class developers extends Model
{
    use hasFactory;

    public function users()
    {
        return $this->hasOne(Users::class);
    }
}
