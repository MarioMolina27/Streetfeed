<?php

namespace App\Http\Controllers\Api;

use App\Models\Delivery;
use App\Models\Marker;
use App\Models\Marker_History;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryResource;
use Illuminate\Support\Facades\DB;


class DeliveryController extends Controller
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
    public function show(Delivery $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery $usuari)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Delivery $user)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Delivery $user)
    {
        //
    }
    public function doReserve(Request $request) {
        //No funciona
        $userId = $request->input('userId');
        $menus = $request->input('menus');
        $assignMarkers = $request->input('assignMarkers');

        DB::beginTransaction();
        try {
            foreach ($menus as $menu) {
                foreach ($assignMarkers as $marker) {
                    $delivery = new Delivery();
                    $delivery->start_time = now();
                    $delivery->id_state = 1;
                    $delivery->id_user = $userId;
                    $delivery->id_marker = $marker['id_marker'];
                    $delivery->id_menu = $menu['id'];
                    $delivery->save();

                    $marker = Marker::find($marker['id_marker']);
                    $marker->num_people_not_eat = $marker->num_people - $marker['people_eat'];
                    if ($marker->num_people_not_eat == 0) {
                        $markerHistory = new Marker_History();
                        $markerHistory->id_state = 2;
                        $markerHistory->id_marker = $marker['id_marker'];
                        $markerHistory->timestamp = now();
                        $markerHistory->save();
                    }
                    $marker->save();
                }
            }
            DB::commit();
            return response()->json(['message' => 'Reserva realizada correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al realizar la reserva'], 500);
        }
    }
}