
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

    public function create(Request $request) {
        try {
            $language = new Languages();
            $language->language_name = $request->language_name;

            if ($language->save()) {
                return response()->json(['status' => 'success', 'message' => 'Language created successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id) {
        try {
            $language = Languages::findOrFail($id);
            $language->language_name = $request->language_name;

            if ($language->save()) {
                return response()->json(['status' => 'success', 'message' => 'Language updated successfully']);
            }
        } catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

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
