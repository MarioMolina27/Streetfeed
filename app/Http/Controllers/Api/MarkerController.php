<?php

namespace App\Http\Controllers\Api;

use App\Models\Marker;
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
        $markers = Marker::where('id_user', $id)->get()->count();
        return response()->json($markers);
    }
}

