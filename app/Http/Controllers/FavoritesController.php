<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Models\Favorites;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{
    /**
     * get all favorites
     *
     * @return void
     */
    public function list(){
        return Favorites::all();
    }

    /**
     * get favorite by id
     *
     * @param [int] $id
     * @return void
     */
    public function item($id){
        return Favorites::whereId($id)->first();
    }

    /**
     * create new
     *
     * @param Request $request
     * @return void
     */
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

    /**
     * update a specific favorite with id
     *
     * @param Request $request
     * @param [int] $id
     * @return void
     */
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

    /**
     * delete a favorite using id
     *
     * @param [int] $id
     * @return void
     */
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

    public function getAllFromOneUser(Request $request) {
        $id = $request->id;
        $favoritesProfile = Favorites::join('users', 'favorites.developer_user_id', '=', 'users.id')
        ->where('recruiter_user_id', '=', $id)
        ->join('developers', 'users.dev_id', '=', 'developers.id')
        ->get();

        return response()->json(['status' => 'success', 'fav user data' => $favoritesProfile]);
    }

    public function getOneFromOneUser(Request $request) {
        $devId = $request->devId;
        $recrutId = $request->recrutId;

        $favoritesProfile = Favorites::join('users', 'favorites.developer_user_id', '=', 'users.id')
        ->where('recruiter_user_id', '=', $recrutId)
        ->where('developer_user_id', '=', $devId)
        ->join('developers', 'users.dev_id', '=', 'developers.id')
        ->get();

        return response()->json(['status' => 'success', 'fav user data' => $favoritesProfile]);
    }

}
