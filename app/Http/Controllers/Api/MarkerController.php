<?php

namespace App\Http\Controllers\Api;

use App\Models\Marker;
use App\Models\Marker_History;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class MarkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuari)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
       
    }

    public function getAllMarkers() {
        $markers = Marker::all();
        $providers = User::with('typeUsers')->where('active', 1)->whereHas('typeUsers', function ($query) {
            $query->where('user_type_user.id_type_user', 2);
        })->get();

        $mergedList = array_merge($markers->toArray(), $providers->toArray());

        return response()->json($mergedList);
    }

    public function getMarkersCreatedByUser($id) {
        $markers = Marker::where('id_user_created', $id)->get()->count();
        return response()->json($markers);
    }

    public function createMarker(Request $request) {
        try {
            $marker = new Marker();
            $marker->num_people = $request->numPeople;
            $marker->num_people_not_eat = $request->numPeople;
            $marker->latitude = $request->lat;
            $marker->longitude = $request->lng;
            if ($request->id_user_created != null) {
                $marker->id_user_created = $request->id_user_creator;
            }
            $marker->save();
            $idMarker = $marker->id;

            $markerHistory = new Marker_History();
            $markerHistory->id_state = 3;
            $markerHistory->id_marker = $idMarker;
            $markerHistory->timestamp = now();
            $markerHistory->save();
            return response()->json(['message' => 'Marker created successfully', 'newId'=> $idMarker], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}

