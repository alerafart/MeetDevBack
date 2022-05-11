<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Models\Languages;
use Illuminate\Http\Request;

class LanguagesController extends Controller
{
    public function list(){
        return Languages::all();
    }

    /**
     * get a single language by id
     *
     * @param [int] $id
     * @return void
     */
    public function item($id){
        return Languages::whereId($id)->first();
    }

    /**
     * Create new language
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request) {
        try {
            $language = new Languages();
            $language->language_name = $request->language_name;
            $language->language_icon = $request->language_icon;

            if ($language->save()) {
                return response()->json(['status' => 'success', 'message' => 'Language created successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Update single language
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function update(Request $request, $id) {
        try {
            $language = Languages::findOrFail($id);
            $language->language_name = $request->language_name;
            $language->language_icon = $request->language_icon;

            if ($language->save()) {
                return response()->json(['status' => 'success', 'message' => 'Language updated successfully']);
            }
        } catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * delete single language with id
     *
     * @param [type] $id
     * @return void
     */
    public function delete($id) {
        try {
            $language = Languages::findOrFail($id);

            if($language->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Language deleted successfully']);
            }
        }catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


}
