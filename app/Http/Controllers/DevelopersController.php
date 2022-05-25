<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Models\Developers;
use App\Models\Users;
use Illuminate\Http\Request;

class DevelopersController extends Controller
{
    /**
     * Get all users list
     *
     * @return objects
     */
    public function list(){
        return Developers::all();
    }

    /**
     * get single developer by id
     *
     * @param [int] $id
     * @return object
     */
    public function item($id){
        return Developers::whereId($id)->first();
    }

    /**
     * Create new developper
     *
     * @param Request $request
     * @return object
     */
    public function create(Request $request) {
        try {
            $developers = new Developers();
            $developers->description = $request->description;
            if ($request->available_for_recruiters !== null) {
                $developers->available_for_recruiters = $request->available_for_recruiters;
            }
            if ($request->available_for_developers !== null) {
                $developers->available_for_developers = $request->available_for_developers;
            }
            $developers->minimum_salary_requested = $request->minimum_salary_requested;
            $developers->maximum_salary_requested = $request->maximum_salary_requested;
            $developers->age = $request->age;
            $developers->years_of_experience = $request->years_of_experience;
            $developers->github_link = $request->github_link;
            $developers->portfolio_link = $request->portfolio_link;
            $developers->other_link = $request->other_link;

            if($developers->save()) {
                return response()->json(['status' => 'success', 'message' => 'Developer created successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Update developper
     *
     * @param Request $request
     * @param [type] $id
     * @return object
     */
    public function update(Request $request, $id) {
        try {
            $developer = Developers::findOrFail($id);
            $developer->label = $request->label;
            $developer->description = $request->description;
            if ($request->available_for_recruiters !== null) {
                $developer->available_for_recruiters = $request->available_for_recruiters;
            }
            if ($request->available_for_developers !== null) {
                $developer->available_for_developers = $request->available_for_developers;
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

            $userProfile = Users::join('developers', 'users.dev_id', '=', 'developers.id')->where('users.dev_id', '=', $id)->first();
            if ($developer->save()) {
                return response()->json(['status' => 'success', 'message' => 'Developer updated successfully', 'userProfile' => $userProfile]);
            }
        } catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Delete developer
     *
     * @param [type] $id
     * @return object
     */
    public function delete($id) {
        try {
            $developer = Developers::findOrFail($id);

            if($developer->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Developer deleted successfully']);
            }
        } catch (\Exception $e) {
            return response()->json (['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
