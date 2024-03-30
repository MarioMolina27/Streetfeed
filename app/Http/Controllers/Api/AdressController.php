<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Adress;
use App\Models\Type_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class AdressController extends Controller
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
    public function show(Adress $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Adress $usuari)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Adress $user)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Adress $user)
    {
        //
    }

    public function getAdreesNumbers(Type_User $type_user) {
        
        $idTypeUser = $type_user->id_type_user;

        $adress = Adress::whereHas('user.typeUsers', function ($query) use ($idTypeUser) {
            $query->where('user_type_user.id_type_user', $idTypeUser);
        })->with(['user.typeUsers'])->get()->groupBy('city');
        
        $adress = $adress->map(function($adress) {
            return $adress->count();
        });
       return response()->json($adress);
    }

    public function getAdressesByUser(Request $request, User $user){
        $adresses = Adress::where('id_user', $user->id_user)->get();
        return response()->json($adresses);
    }
}