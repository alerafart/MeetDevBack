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
     * @return object
     */
    public function list()
    {
        return Favorites::all();
    }

    /**
     * get one favorite by id
     *
     * @param [int] $id
     * @return object
     */
    public function item($id)
    {
        return Favorites::whereId($id)->first();
    }

    /**
     * create new
     *
     * @param Request $request
     * @return object
     */
    public function create(Request $request)
    {
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
     * @return object
     */
    public function update(Request $request, $id)
    {
        try {
            $favorite = Favorites::findOrFail($id);
            $favorite->developer_id = $request->developer_id;
            $favorite->recruiter_id = $request->recruiter_id;

            if ($favorite->save()) {
                return response()->json(['status' => 'success', 'message' => 'Favorite updated successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * delete a favorite using id
     *
     * @param [int] $id
     * @return object
     */
    public function delete($id)
    {
        try {
            $favorite = Favorites::findOrFail($id);

            if ($favorite->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Favorite deleted successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    /**
     * Function that will retrieve all favorites from one user profile, using their id
     *
     * @param [int] $id
     * @return objects
     */
    public function getAllFromOneUser($id)
    {
        $favs= Favorites::where('recruiter_user_id', '=', $id)->get();

        $favUsers = [];
        foreach ($favs as $fav) {
            $devUserId = $fav->developer_user_id;
            $favoriteProfile = Users::join('developers', 'users.dev_id', '=', 'developers.id')
            ->where('users.id', '=', $devUserId)
            ->get();
            //$favUsers[] = $favoriteProfile;
        }

    return response()->json(['status' => 'success', 'favoritesDetails' => $favs , 'favoriteUsersData' => $favUsers]);
    }


    /**
     * Function that will retrieve one complete profile marked as favorite by one user, using their id
     *
     * @param Request $request
     * @return objects
     */
    public function getOneFromOneUser(Request $request)
    {
        $devUserId = $request->devId;
        $recrutUserId = $request->recrutId;

        $favoritesProfile = Favorites::join('users', 'favorites.developer_user_id', '=', 'users.id')
        ->where('recruiter_user_id', '=', $recrutUserId)
        ->where('developer_user_id', '=', $devUserId)
        ->join('developers', 'users.dev_id', '=', 'developers.id')
        ->get();

        $favId = Favorites::where('developer_user_id', '=', $devUserId)
        ->where('recruiter_user_id', '=', $recrutUserId)
        ->get('id');

        return response()->json(['status' => 'success', 'favoriteId' => $favId, 'favoriteUserDetails' => $favoritesProfile]);
    }


    /**
     * Add a new favorite to a recruiter profile, using said recruiter id and developer user id
     *
     * @param Request $request
     * @return object
     */
    public function AddNewToProfile(Request $request)
    {
        try {
            $favorite = new Favorites();
            $favorite->developer_user_id = $request->devUserId;
            $favorite->recruiter_user_id = $request->recrutUserId;

            if ($favorite->save()) {
                return response()->json(['status' => 'success', 'message' => 'Favorite created successfully', 'newFavorite' => $favorite]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
