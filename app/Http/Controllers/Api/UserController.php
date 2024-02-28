<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // $resultatAprenentages = ResultatAprenentage::with([
        //     'criterisAvaluacio', 
        //     'criterisAvaluacio.rubrica', 
        //     'criterisAvaluacio.usuari_has_criterisAvaluacio' => function (Builder $query) use ($idUser){
        //         $query->where('id', $idUser)->withPivot('nota');
        //     }
        // ])->where('moduls_id', $modulId)->get();

        $users = User::with(['addresses', 'schedules'])->get();


        return UserResource::collection($users);
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
        //
    }
}
