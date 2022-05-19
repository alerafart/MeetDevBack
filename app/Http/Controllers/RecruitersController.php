<?php

namespace App\Http\Controllers;

use App\Models\Recruiters;
use App\Models\Users;
use Illuminate\Http\Request;

class RecruitersController extends Controller
{
    /**
     * get all recruiters list
     *
     * @return void
     */
    public function list(){
        return Recruiters::all();
    }

    /**
     * get single recruiters by id
     *
     * @param [int] $id
     * @return void
     */

    public function item($id){
        return Recruiters::whereId($id)->first();
    }

    /**
     * Create new recruiter
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request){

        try {
            $recruiters = new Recruiters();
            $recruiters->company_name = $request->company_name;
            $recruiters->needs_description = $request ->needs_description;
            $recruiters->web_site_link = $request->web_site_link;

            if ($recruiters->save()) {
                return response()->json(['status' => 'success', 'message' => 'Recruiter created successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Update single recruiter by id
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function update(Request $request, $id){
        try {
            $recruiters = Recruiters::findOrFail($id);
            $recruiters->company_name = $request->company_name;
            $recruiters->needs_description = $request ->needs_description;
            $recruiters->web_site_link = $request->web_site_link;

            $userProfile = Users::join('recruiters', 'users.dev_id', '=', 'recruiters.id')->where('users.dev_id', '=', $id)->first();
            if ($recruiters->update()) {
                return response()->json(['status' => 'success', 'message' =>'Recruiter updated successfully', 'userProfile' => $userProfile]);
            }

        } catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Delete single recruiter by id
     *
     * @param [type] $id
     * @return void
     */
    public function delete($id) {

        try {
            $recruiters = Recruiters::findOrFail($id);

            if ($recruiters->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Recruiter deleted succesfully']);
            }
        } catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
