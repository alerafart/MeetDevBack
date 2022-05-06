<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Models\Favorites;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function list(){
        return Favorites::all();
    }

    public function create(Request $request) {
        try {
            $favorite = new Favorites();
            $favorite->developer_id = $request->developer_id;
            $favorite->recruiter_id = $request->recruiter_id;

            if ($favorite->save()) {
                return response()->json(['status' => 'success', 'message' => 'Favorite created successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id) {
        try {
            $favorite = Favorites::findOrFail($id);
            $favorite->developer_id = $request->developer_id;
            $favorite->recruiter_id = $request->recruiter_id;

            if ($favorite->save()) {
                return response()->json(['status' => 'success', 'message' => 'Favorite updated successfully']);
            }
        } catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function delete($id) {
        try {
            $favorite = Favorites::findOrFail($id);

            if($favorite->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Favorite deleted successfully']);
            }
        }catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


}
