<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Developers;
use App\Models\Languages;
use App\Models\Dev_lang;
//use App\Http\Controllers\DevelopersController;
use App\Models\Recruiters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * get all users
     *
     * @return void
     */
    public function list(){
        return Users::all();
    }

    /**
     * get user by id
     *
     * @param [int] $id
     * @return void
     */
    public function item($id){
        return Users::whereId($id)->first();
    }

    /**
     * insert new user into entity
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request){
        try {
            $users = new Users();
            $users->lastname = $request->lastname;
            $users->firstname = $request->firstname;
            $users->city = $request->city;
            $users->zip_code = $request->zip_code;
            $users->email_address = $request->email_address;
            $users->password = $request->password;
            $users->phone = $request->phone;
            // $users->dev_id = $request->dev_id;
            // $users->recrut_id = $request ->recrut_id;
            $users->subscribe_to_push_notif = $request->subscribe_to_push_notif;
            $users->profile_picture = $request ->profile_picture;

            if ($users->save()) {
                return response()->json(['status' => 'success', 'message' => 'User created successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    /**
     * create new developer user into DB which means: 1 new row in the Users tables, 1 other in the Developers table and the id of the dev neawly created row being pushed into the Users dev_id column.
     *
     * @param Request $request
     * @return void
     */
    public function createNewDevUser(Request $request){
        //$developersController = new DevelopersController();

        //check if user email address exists in DB, if not proceed to creation
        if (Users::where('email_address', '=', $request->email_address)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'email address already existing in database'], 400);
        }
        else {
            try {
                $user = new Users();
                $user->lastname = $request->lastname;
                $user->firstname = $request->firstname;
                $user->city = $request->city;
                $user->zip_code = $request->zip_code;
                $user->email_address = $request->email_address;
                $password = $request->password;
                $hashedPassword = Hash::make($password);
                $user->password = $hashedPassword;
                $user->phone = $request->phone;
                $user->subscribe_to_push_notif = $request->subscribe_to_push_notif;
                $user->profile_picture = $request->profile_picture;

                if ($user->save()) {
                    try {
                        $developer = new Developers();
                        $developer->description = $request->description;
                        $developer->available_for_recruiters = $request->available_for_recruiters;
                        $developer->available_for_developers = $request-> available_for_developers;
                        $developer->minimum_salary_requested = $request->minimum_salary_requested;
                        $developer->maximum_salary_requested = $request->maximum_salary_requested;
                        $developer->age = $request->age;
                        $developer->years_of_experience = $request->years_of_experience;
                        $developer->github_link = $request->github_link;
                        $developer->portfolio_link = $request->portfolio_link;
                        $developer->other_link = $request->other_link;

                        if ($developer->save()) {
                            $devId = $developer->id;
                            $user->dev_id = $devId;
                            $user->save();

                            $language = Languages::where('language_name', '=', $request->language)->first();
                            if ($language) {
                                $dev_lang = new Dev_lang();
                                $dev_lang->language_id = $language->id;
                                $dev_lang->developer_id	 = $devId;
                                $dev_lang->save();

                                if ($user->save() && $dev_lang->save()) {
                                    return response()->json(['status' => 'success', 'message' =>'Developer user created successfully and language saved', 'general' => $user, 'spec' => $developer, 'lang' => $dev_lang]);
                                } else {
                                    return response()->json(['status' => 'error', 'message' => 'Language not saved'], 400);
                                }
                            } elseif (!$language) {
                                return response()->json(['status' => 'error', 'message' => 'Language does not exists, profile save'], 400);

                                $request->language;

                                if ($user->save()) {
                                    return response()->json(['status' => 'success', 'message' =>'Developer user created successfully']);
                                }
                            }
                        }
                        }catch (\Exception $e) {
                        $user->delete();
                        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                    }
                }
            }catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    /**
     * create new recruiter user into DB which means: 1 new row in the Users tables, 1 other in the Recruiters table and the id of the recruiter newly created row being pushed into the Users recrut_id column.
     *
     * @param Request $request
     * @return void
     */

    public function createNewRecruiterUser(Request $request){
        //$developersController = new DevelopersController();

        //check if user email address exists in DB, if not proceed to creation
        if (Users::where('email_address', '=', $request->email_address)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'email address already existing in database'], 400);
        }
        else {
            try {
                $user = new Users();
                $user->lastname = $request->lastname;
                $user->firstname = $request->firstname;
                $user->city = $request->city;
                $user->zip_code = $request->zip_code;
                $user->email_address = $request->email_address;
                $password = $request->password;
                $hashedPassword = Hash::make($password);
                $user->password = $hashedPassword;
                $user->phone = $request->phone;
                $user->subscribe_to_push_notif = $request->subscribe_to_push_notif;
                $user->profile_picture = $request->profile_picture;

                if ($user->save()) {
                    try {
                        $recruiter = new Recruiters();
                        $recruiter->company_name = $request->company_name;
                        $recruiter->needs_description = $request->needs_description;
                        $recruiter->web_site_link = $request-> web_site_link;

                        if ($recruiter->save()) {
                            $recruiterId = $recruiter->id;
                            $user->recrut_id = $recruiterId;

                            if ($user->save()) {
                                return response()->json(['status' => 'success', 'message' =>'Recruter user created successfully', 'general' => $user, 'spec' => $recruiter]);
                            }
                        }
                    } catch (\Exception $e) {
                        $user->delete();
                        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                    }
                }
            }catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }


    /**
     * update a specific user row
     *
     * @param Request $request
     * @param [int] $id
     * @return void
     */
    public function update(Request $request, $id){
        try {
            $users = Users::findOrFail($id);
            $users->lastname = $request->lastname;
            $users->firstname = $request ->firstname;
            $users->city = $request ->city;
            $users->zip_code = $request ->zip_code;
            $users->email_address = $request->email_address;
            $users->password = $request ->password;
            $users->phone = $request ->phone;
            $users->subscribe_to_push_notif = $request->subscribe_to_push_notif;
            $users->profile_picture = $request ->profile_picture;

            if ($users->save()) {
                return response()->json(['status' => 'success', 'message' =>'User updated successfully' ]);
            }

        } catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    /**
     * Delete user row
     *
     * @param [int] $id
     * @return void
     */
    public function delete($id) {

        try {
            $users = Users::findOrFail($id);

            if ($users->delete()) {
                return response()->json(['status' => 'succes', 'message' => 'User deleted succesfully']);
            }
        } catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    /**
     * User login method that return user data, including dev or recruiter info
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request){
        $isDev = false;
        $isRecruiter = false;

        $email_address = $request->email_address;
        $password = $request->password;
        $user = Users::where('email_address', '=', $email_address)->first();
        if (!$user) {
            return response()->json(['status' => 'success', 'message' => 'Login Fail, please check email id']);
        }

        if((Hash::check($password, $user->password))){ //($password===$user->password) {
            if(!empty($user->dev_id)) {
                $isDev = true;

                $dev_id = $user->dev_id;
                $dev = DB::table('developers')
                ->select('*')
                ->where('id', '=', $dev_id)
                ->get();

                return response()->json(['status' => 'success', 'message' => 'Login successfull', 'isDev' => $isDev, 'isRecruiter' => $isRecruiter, 'general' => $user, 'spec' => $dev]);
            } else if(!empty($user->recrut_id)) {
                $isRecruiter = true;

                $recrut_id = $user->recrut_id;
                $recrut = DB::table('recruiters')
                ->select('*')
                ->where('id', '=', $recrut_id)
                ->get();
                return response()->json(['status' => 'success', 'message' => 'Login successfull','isDev' => $isDev, 'isRecruiter' => $isRecruiter, 'general' => $user, 'spec' => $recrut]);
            }

        }else {
            return response()->json(['status' => 'error', 'message' => 'Login fail, pls check password'], 400);
        }

    }



    public function getDevSearchResults(Request $request) {
        $language = $request->language;
        $city = $request->city;
        $exp = $request->exp;
        //return response()->json([$language, $city, $exp]);
        /*$queryResults = DB::table('users')
        ->join("developers", function($join) use ($city, $exp, $language) {
            $join->on("developers.id", "=", "users.dev_id")
            ->where("users.city", "=", $city)
            ->where("developers.years_of_experience", "=", $exp)
            ->whereIn("users.dev_id", function($query) use ($language) {
            $query->from("developers", "languages" , "dev_langs")
            ->select("developers.id")
            ->where("languages.id", "=", "dev_langs.language_id")
            ->where("developers.id", "=", "dev_langs.developer_id")
            ->where("languages.id", "=", $language);
            //->where("$city", "=", $request->city);
        });
        })
        ->get("users.*");*/

        /*DB::table('users')
        ->select('*')
        ->join('developers',function($join) {
            $join->on('developers.id','=','users.dev_id')
            ->on('users.city','=','$city')
            ->on('developers.years_of_experience','=','$exp')
            ->whereNotIn('users.dev_id',(function ($query) {
                $query->from('developers')
                    ->crossJoin('languages'
                    ->crossJoin('dev_langs'
                    ->select('developers.id')
                    ->where('languages.id','=',DB::raw('dev_langs.language_id'))
                    ->where('developers.id','=',DB::raw('dev_langs.developer_id'))
                    ->where('languages.language_name','=',DB::raw('$language'))
            }
        }
        ->get();*/

        //$queryResults = DB::table('languages') ->join('dev_langs', 'dev_langs.language_id', '=', 'languages.id')->where('languages.language_name', '=', $language) ->get('dev_langs.developer_id');

        $results = DB::select('SELECT * FROM `users`
        JOIN `developers`
        ON `developers`.`id` = `users`.`dev_id`
        AND `users`.`city`= :city
        AND `developers`.`years_of_experience` = :exp
        AND `users`.`dev_id` IN
            (SELECT `developers`.`id` FROM  `developers`,  `languages` , `dev_langs`
            WHERE  `languages`.`id` = `dev_langs`.`language_id`
            AND `developers`.`id` = `dev_langs`.`developer_id`
            AND `languages`.`language_name`= :language)', ['exp' => $exp, 'city' => $city, 'language' => $language]);

        $array = [];
        foreach($results as $res) {
            $dev = $res->dev_id;
            $lan = DB::select('SELECT `language_name`, `language_icon` FROM `languages`, `developers`, `dev_langs`
            WHERE  `languages`.`id` = `dev_langs`.`language_id`
            AND `developers`.`id` = `dev_langs`.`developer_id`
            AND `developers`.`id`= :dev', ['dev' => $dev]);
            $array += [$dev => $lan];
        }

       /* $array = DB::select('SELECT `language_name` FROM `languages` , `developers`, `dev_langs`
            WHERE  `languages`.`id` = `dev_langs`.`language_id`
            AND `developers`.`id` = `dev_langs`.`developer_id`
            AND `developers`.`id`= :id', ['id' => $dev]);
*/
       // $results = Users::join('developers', 'developers.id', '=', 'users.dev_id')
        //->join('languages', )

        return response()->json(['res' => $results, 'lang' => $array]);

    }
}

