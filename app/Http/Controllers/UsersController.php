<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Developers;
use App\Http\Controllers\DevelopersController;
use App\Models\Recruiters;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

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
            if ($request->subscribe_to_push_notif !== null) {
                $users->subscribe_to_push_notif = $request->subscribe_to_push_notif;
            }
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
     * @return object
     */
    public function createNewDevUser(Request $request){
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
                $user->department = $request->department;
                $user->zip_code = $request->zip_code;
                $user->email_address = $request->email_address;
                $password = $request->password;
                $hashedPassword = Hash::make($password);
                $user->password = $hashedPassword;
                $user->phone = $request->phone;
                if ($request->subscribe_to_push_notif !== null) {
                    $user->subscribe_to_push_notif = $request->subscribe_to_push_notif;
                }
                $user->profile_picture = $request->profile_picture;

                if ($user->save()) {
                    try {
                        $developer = new Developers();
                        $developer->label = $request->label;
                        $developer->description = $request->description;
                        if ($request->available_for_recruiters !== null) {
                            $user->available_for_recruiters = $request->available_for_recruiters;
                        }
                        if ($request->available_for_developers !== null) {
                            $user->available_for_developers = $request->available_for_developers;
                        }
                        $developer->minimum_salary_requested = $request->minimum_salary_requested;
                        $developer->maximum_salary_requested = $request->maximum_salary_requested;
                        $developer->age = $request->age;
                        $developer->languages = $request->languages;
                        $developer->years_of_experience = $request->years_of_experience;
                        $developer->english_spoken = $request->english_spoken;
                        $developer->github_link = $request->github_link;
                        $developer->portfolio_link = $request->portfolio_link;
                        $developer->other_link = $request->other_link;

                        if ($developer->save()) {
                            $devId = $developer->id;
                            $user->dev_id = $devId;

                                if ($user->save()) {
                                    return response()->json(['status' => 'success', 'message' =>'Developer user created successfully and language saved', 'general' => $user, 'spec' => $developer]);
                                } else {
                                    return response()->json(['status' => 'error', 'message' => 'dev_id not saved'], 400);
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
                $user->department = $request->department;
                $user->zip_code = $request->zip_code;
                $user->email_address = $request->email_address;
                $password = $request->password;
                $hashedPassword = Hash::make($password);
                $user->password = $hashedPassword;
                $user->phone = $request->phone;
                if ($request->subscribe_to_push_notif !== null) {
                    $user->subscribe_to_push_notif = $request->subscribe_to_push_notif;
                }
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
                                event(new Registered($user));

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
            $users->department = $request->department;
            $users->zip_code = $request ->zip_code;
            $users->phone = $request ->phone;
            $users->subscribe_to_push_notif = $request->subscribe_to_push_notif;
            $users->profile_picture = $request ->profile_picture;

            if ($users->save()) {
                return response()->json(['status' => 'success', 'message' =>'User updated successfully'], 200);
            }

        } catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    /**
     * update a user profile and corresponding specificities table, using id for identification
     *
     * @param Request $request
     * @param [int] $id
     * @return void
     */
    public function updateUser(Request $request, $id){
        try {
            $this->update($request, $id);

            if(response()->json(["success"])){
                $profile = Users::where('id', '=', $id)->first();
                $profileRec = $profile->recrut_id;
                $profileDev = $profile->dev_id;

                if (isset($profileDev)) {
                    $devCtrl = new DevelopersController;
                    return $devCtrl->update($request, $profileDev);
                } elseif (isset($profileRec)) {
                    $recrtCtrl = new RecruitersController;
                    return $recrtCtrl->update($request, $profileRec);
                }

                //the response status is handle in the update() method used above
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


    /**
     * Method that will handle search results for developer profiles depending on city
     *
     * @param Request $request
     * @return objects array
     */
    public function getDevSearchResults(Request $request) {
        $city = $request->city;

        $results = Users::where('city', '=', $city)
            ->whereNotNull('dev_id')
            ->join('developers', 'users.dev_id', '=', 'developers.id')
            ->get('users.id');

        $dev =[];
        $devs = $results->map(function($item){

            $dev['userId'] = $item->id;

            $devDetails = Users::join('developers', 'users.dev_id', '=', 'developers.id')
                ->where('users.id', '=', $item->id)
                ->get();

            $dev['userDetails'] = $devDetails;
            return $dev;
        });

        return response()->json(['status' => 'success', 'message' => 'Profile loaded successfuly', 'res' => $devs]);
    }





 /**
  * TEST EMAIL USER MODEL
  */
  /**
     * insert new user into entity
     *
     * @param Request $request
     * @return void
     */
    public function simpleCreate(Request $request){
        try {
            $users = new User();
            $users->lastname = $request->lastname;
            $users->firstname = $request->firstname;
            $users->city = $request->city;
            $users->zip_code = $request->zip_code;
            $users->email_address = $request->email_address;
            $users->password = $request->password;
            $users->phone = $request->phone;
            if ($request->subscribe_to_push_notif !== null) {
                $users->subscribe_to_push_notif = $request->subscribe_to_push_notif;
            }
            $users->profile_picture = $request ->profile_picture;

            if ($users->save()) {
                //$users->sendEmailVerificationNotification();
               // return "yolo";
                //if (Event::dispatch(new Registered($users))) {return "yolo";}
                Event::dispatch(new Registered($users));
                return "yolo";

                //return response()->json(['status' => 'success', 'message' => 'User created successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


}

