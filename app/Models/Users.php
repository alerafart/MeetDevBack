<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;

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

    public function developers() {
        return $this->hasOne( "App\Models\Developers" );
    }

    public function favorites() {
        return $this->hasMany( "App\Models\Favorites" );
    }

    public function messages() {
        return $this->hasMany( "App\Models\Messages" );
    }




    public function getSearchResults($language, $city, $exp) {

        $pdo = DB::getPDO();
        $sql = 'SELECT * FROM `users`
            JOIN `developers`
            ON `developers`.`id` = `users`.`dev_id`
            AND `users`.`city` = $city
            AND `developers`.`years_of_experience` = $exp
            AND `users`.`dev_id` IN
                (SELECT `developers`.`id` FROM  `developers`,  `languages` , `dev_langs`
                WHERE  `languages`.`id` = `dev_langs`.`language_id`
                AND `developers`.`id` = `dev_langs`.`developer_id`
                AND `languages`.`language_name`= $language)';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\AppUser');
        return $results;


    }


}
