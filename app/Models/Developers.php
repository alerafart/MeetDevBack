<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class developers extends Model
{
    use hasFactory;

    /**
     * defining DB relationships
     *
     * @return void
     */
    public function usersRelationship() {
        return $this->hasOne(Users::class);
    }

    public function languages() {
        return $this->HasMany('App\Models\Languages', 'dev_lang');
    }

    public function getUsersAttribute() {
        return $this->usersRelationship->dev_id;
    }

}
