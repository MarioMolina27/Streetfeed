<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        
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
    public function getProviderByNick($nickname, User $user) {
        $currentDay = Carbon::now()->dayOfWeek;
        $currentUserLat = $user->latitude;
        $currentUserLng = $user->longitude;
        $currentUser = $user;
        
        $provider = User::with([
                'addresses.roadType', 
                'schedules' => function ($query) use ($currentDay) {
                    $query->where('day', $currentDay); 
                },
                'typeUsers' => function ($query) {
                    $query->whereIn('type_user.id_type_user', [2, 4])->withPivot('type_of_provider');
                },
                'menus.launchpack',
                'favoriteProviders'
            ])
            ->whereHas('typeUsers', function ($query) {
                $query->whereIn('type_user.id_type_user', [2, 4]);
            })
            ->where('nickname', $nickname)
            ->first();
    
        if ($provider) {
            $provider->distance = $this->haversineDistance($currentUserLat, $currentUserLng, $provider->latitude, $provider->longitude);
            $provider->is_favorite = $currentUser->favoriteProviders->contains($provider->id_user);
        }
    
        return new UserResource($provider);
    }
    public function getMoreNearProviders(User $user) {
        $currentDay = Carbon::now()->dayOfWeek;
        $currentUserLat = $user->latitude;
        $currentUserLng = $user->longitude;
        $currentUser = $user;

        $users = User::with([
            'addresses.roadType', 
            'schedules' => function ($query) use ($currentDay) {
                $query->where('day', $currentDay); 
            },
            'typeUsers' => function ($query) {
                $query->whereIn('type_user.id_type_user', [2, 4])->withPivot('type_of_provider');
            },
            'menus.launchpack',
            'favoriteProviders'
        ])
        ->whereHas('typeUsers', function ($query) {
            $query->whereIn('type_user.id_type_user', [2, 4]);
        })
        ->get();

        $users->each(function ($user) use ($currentUserLat, $currentUserLng, $currentUser) {
            $user->distance = $this->haversineDistance($currentUserLat, $currentUserLng, $user->latitude, $user->longitude);
            $user->is_favorite = $currentUser->favoriteProviders->contains($user->id_user);
        });

        $users = $users->sortBy('distance');

        return UserResource::collection($users);
    }
    public function getBetterProviders(User $user) {
        $currentDay = Carbon::now()->dayOfWeek;
        $currentUserLat = $user->latitude;
        $currentUserLng = $user->longitude;
        $currentUser = $user;
    
        $users = User::with([
            'addresses.roadType', 
            'schedules' => function ($query) use ($currentDay) {
                $query->where('day', $currentDay); 
            },
            'typeUsers' => function ($query) {
                $query->whereIn('type_user.id_type_user', [2, 4])->withPivot('type_of_provider');
            },
            'menus.launchpack',
            'favoriteProviders'
        ])
        ->whereHas('typeUsers', function ($query) {
            $query->whereIn('type_user.id_type_user', [2, 4]);
        })
        ->get();
    
        $users->each(function ($user) use ($currentUserLat, $currentUserLng, $currentUser) {
            $user->distance = $this->haversineDistance($currentUserLat, $currentUserLng, $user->latitude, $user->longitude);
            $user->is_favorite = $currentUser->favoriteProviders->pluck('id_user')->contains($user->id_user);
        });
    
        $users = $users->sortByDesc(function ($user) {
            return $user->favoriteProviders->count();
        });
    
        return UserResource::collection($users);
    }
    public function getFavouritesProviders(User $user) {
        $currentDay = Carbon::now()->dayOfWeek;
        $currentUserLat = $user->latitude;
        $currentUserLng = $user->longitude;
        $currentUser = $user;

        $users = User::with([
            'addresses.roadType', 
            'schedules' => function ($query) use ($currentDay) {
                $query->where('day', $currentDay); 
            },
            'typeUsers' => function ($query) {
                $query->whereIn('type_user.id_type_user', [2, 4])->withPivot('type_of_provider');
            },
            'menus.launchpack',
            'favoriteProviders'
        ])
        ->whereHas('typeUsers', function ($query) {
            $query->whereIn('type_user.id_type_user', [2, 4]);
        })
        ->get();

        $favoriteUsers = $users->filter(function ($user) use ($currentUser) {
            return $currentUser->favoriteProviders->pluck('id_user')->contains($user->id_user);
        });
        
        $favoriteUsers->each(function ($user) use ($currentUserLat, $currentUserLng, $currentUser) {
            $user->distance = $this->haversineDistance($currentUserLat, $currentUserLng, $user->latitude, $user->longitude);
            $user->is_favorite = true;
        });
    
        $favoriteUsers = $favoriteUsers->sortBy('distance');
    
        return UserResource::collection($favoriteUsers);
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371;
    
        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);
    
        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);
    
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    
        $distance = $earthRadius * $c;

        return round($distance, 1);
    }

    public function toggleFavoriteProvider(Request $request)
    {
        $userId = $request->input('userId');
        $providerId = $request->input('providerId');
        $user = User::find($userId);

        if ($user->favoriteProviders()->where('user.id_user', $providerId)->exists()) {
            $user->favoriteProviders()->detach($providerId);
            return response()->json(['message' => 'Proveedor eliminado de favoritos']);
        } else {
            $user->favoriteProviders()->attach($providerId);
            return response()->json(['message' => 'Proveedor añadido a favoritos']);
        }
    }
}

