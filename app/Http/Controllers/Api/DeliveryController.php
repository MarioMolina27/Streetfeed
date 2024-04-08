<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Marker;
use App\Models\Delivery;
use App\Models\Launch_Pack;
use Illuminate\Http\Request;
use App\Models\Marker_History;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryResource;


class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public const DELIVERY_KG = 0.5;
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
        $userId = $request->input('userId');
        $menus = $request->input('menus');
        $assignMarkers = $request->input('assignMarkers');

        DB::beginTransaction();
        try {
            $markerIndex = 0;
            $assignMarker = $assignMarkers[$markerIndex];
            foreach ($menus as $menu) {
                $remainingLaunchpacks = $menu['launchpacks'];
                while ($remainingLaunchpacks > 0 && $markerIndex < count($assignMarkers)) {
                    $numLaunchpacksWithMarker = min($remainingLaunchpacks, $assignMarker['people_eat']);
        
                    for ($i = 0; $i < $numLaunchpacksWithMarker; $i++) {
                        $delivery = new Delivery();
                        $delivery->start_time = now();
                        $delivery->id_state = 1;
                        $delivery->id_user = $userId;
                        $delivery->id_marker = $assignMarker['id_marker'];
                        $delivery->id_menu = $menu['id'];
                        $delivery->save();
        
                        $marker = Marker::find($assignMarker['id_marker']);
                        $marker->num_people_not_eat -= 1;
                        $assignMarker['people_eat'] -= 1;
                        $marker->save();
                        
                        $markerHistory = new Marker_History();
                        $markerHistory->id_state = 2;
                        $markerHistory->id_marker = $marker['id_marker'];
                        $markerHistory->timestamp = now();
                        $markerHistory->save(); 
                    }
        
                    $remainingLaunchpacks -= $numLaunchpacksWithMarker;
        
                    if ($marker['num_people_not_eat'] == 0) {
                        $markerIndex++;
                        if (isset($assignMarkers[$markerIndex])) {
                            $assignMarker = $assignMarkers[$markerIndex];
                        }
                    }
                }
                
                $launchPacksToDelete = Launch_Pack::where('id_menu', $menu['id'])->take($menu['launchpacks'])->get();
        
                foreach ($launchPacksToDelete as $launchPack) {
                    $launchPack->delete();
                }
            }

            DB::commit();
            return response()->json(['message' => 'Reserva realizada correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al realizar la reserva'], 500);
        }
    }

    public function doSuggestReserve(Request $request) {
        $userId = $request->input('userId');
        $providerId = $request->input('providerId');
        $markerId = $request->input('markerId');

        DB::beginTransaction();
        try {
            $menuId = User::find($providerId)->menus()
            ->whereHas('launchpack')
            ->value('id_menu');

            $delivery = new Delivery();
            $delivery->start_time = now();
            $delivery->id_state = 1;
            $delivery->id_user = $userId;
            $delivery->id_marker = $markerId;
            $delivery->id_menu = $menuId;
            $delivery->save();

            $marker = Marker::find($markerId);
            $marker->num_people_not_eat -= 1;
            $marker->save();

            $markerHistory = new Marker_History();
            $markerHistory->id_state = 2;
            $markerHistory->id_marker = $marker['id_marker'];
            $markerHistory->timestamp = now();
            $markerHistory->save();

            $launchPack = Launch_Pack::where('id_menu', $menuId)->first();
            $launchPack->delete();

            DB::commit();
            return response()->json(['message' => 'Reserva realizada correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al realizar la reserva'], 500);
        }
    }

    public function calculateDeliveryKg(Request $request) {
        $deliveryKg = self::DELIVERY_KG; 
        $deliveryCount = Delivery::get()->where('id_state', 3)->count();
        $kg = $deliveryCount * $deliveryKg;
        return response()->json(['kg' => $kg]);
    }

    public function getDeliveriesByMonth(Request $request) {
        $deliveries = Delivery::all();
       
        $deliveries = $deliveries->groupBy(function ($date) {
            return \Carbon\Carbon::parse($date->start_time)->format('Y-m');
        })->sortBy(function ($group, $key) {
            return $key;
        });

        $deliveries = $deliveries->map(function($month) {
            return $month->count();
        });

        return response()->json([$deliveries]);
    }

    public function getTotalDeliveries() {
        $deliveries = Delivery::get()->where('id_state', 3)->count();
        return response()->json(['deliveries' => $deliveries]);
    }

    public function getUserDeliveries(User $user) {
        $deliveries = Delivery::where('id_user', $user->id_user)
                            ->where('id_state', '!=', 3)
                            ->with('marker')
                            ->with('state')
                            ->with('user')
                            ->with(['menu.user'=> function ($query) {
                                $currentDay = Carbon::now()->dayOfWeek;
                                $query->with(['schedules' => function ($query) use ($currentDay) {
                                    $query->where('day', $currentDay);
                                }]);
                            }])
                            ->get();

        return $deliveries;
    }

    public function doCollect(Request $request) {
        $deliveryIds = $request->input('deliveryIds');
        try {
            foreach ($deliveryIds as $deliveryId) {
                $delivery = Delivery::find($deliveryId);
                $delivery->id_state = 2;
                $delivery->save();
            }
            return response()->json(['message' => 'Recogida realizada correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al realizar la recogida'], 500);
        }
    }
    public function doDeliver(Request $request) {
        $deliveryId = $request->input('deliveryId');
        try {
            $delivery = Delivery::find($deliveryId);
            $delivery->id_state = 3;
            $delivery->finish_time = now();
            $delivery->save();
            return response()->json(['message' => 'Entrega realizada correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al realizar la entrega'], 500);
        }
    }
    public function getNumDeliveriesByUser($id) {
        $deliveries = Delivery::get()->where('id_user', $id)->where('id_state', 3)->count();
        return response()->json($deliveries);
    }

    public function getDeliveriesByKgUser($id) {
        $deliveries = Delivery::get()->where('id_user', $id)->where('id_state', 3)->count();
        $kg = $deliveries * self::DELIVERY_KG;
        return response()->json(['kg' => $kg]);
    }

    public function getProviderDeliveries(User $user) {
        $deliveries = Delivery::whereHas('menu', function ($query) use ($user) {
            $query->where('id_user', $user->id_user);
        })
        ->where('id_state', '=', 1)
        ->with('marker')
        ->with('state')
        ->with('user')
        ->with(['menu.user'=> function ($query) {
            $currentDay = Carbon::now()->dayOfWeek;
            $query->with(['schedules' => function ($query) use ($currentDay) {
                $query->where('day', $currentDay);
            }]);
        }])
        ->get();
        
        $deliveriesGroupedByUser = $deliveries->groupBy('user.id_user');

        return $deliveriesGroupedByUser;
    }

    public function getNumProviderDeliveries(User $user){
        $deliveries = Delivery::whereHas('menu', function ($query) use ($user) {
            $query->where('id_user', $user->id_user);
        })
        ->where('id_state', '=', 3)
        ->with('user')
        ->with(['menu.user'])
        ->get();

        return $deliveries->count();
    }
}