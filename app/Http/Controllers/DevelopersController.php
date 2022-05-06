<?php

namespace App\Http\Controllers;

use App\Models\Developers;
use Illuminate\Http\Request;

class DevelopersController extends Controller
{
    public function list(){
        return Developers::all();
    }

    public function create(Request $request) {
        try {
            $developers = new Developers();
            $developers->description = $request->description;
            $developers->available_for_recruiters = $request->available_for_recruiters;
            $developers->available_for_developers = $request-> available_for_developers;
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

    public function update(Request $request, $id) {
        try {
            $developer = Developers::findOrFail($id);
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
                return response()->json(['status' => 'success', 'message' => 'Developer updated successfully']);
            }
        } catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

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
