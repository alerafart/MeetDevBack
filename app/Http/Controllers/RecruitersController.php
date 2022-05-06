<?php

namespace App\Http\Controllers;

use App\Models\Recruiters;
use Illuminate\Http\Request;

class RecruitersController extends Controller
{
    public function list(){
        return Recruiters::all();
    }

    public function create(Request $request){

        try {
            $recruiters = new Recruiters();
            $recruiters->company_name = $request->company_name;
            $recruiters->needs_description = $request ->needs_description;
            $recruiters->web_site_link = $request->web_site_link;

            if ($recruiters->save()) {
                return response()->json(['status' => 'succes', 'message' => 'Recruiter created successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id){
        try {
            $recruiters = Recruiters::findOrFail($id);
            $recruiters->company_name = $request->company_name;
            $recruiters->needs_description = $request ->needs_description;
            $recruiters->web_site_link = $request->web_site_link;

            if ($recruiters->update()) {
                return response()->json(['status' => 'succes', 'message' =>'Recruiter updated successfully' ]);
            }

        } catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function delete($id) {

        try {
            $recruiters = Recruiters::findOrFail($id);

            if ($recruiters->delete()) {
                return response()->json(['status' => 'succes', 'message' => 'Recruiter deleted succesfully']);
            }
        } catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
