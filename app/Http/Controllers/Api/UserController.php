<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Models\User;
use App\Models\Marker;
use App\Models\Type_User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\MarkerResource;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::with('typeUsers')->get();  
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
        try 
        {
            $user->active = 0;
            $user->save();
        } 
        catch (\Exception $e) 
        {
            return response()->json(['message' => 'Error al eliminar el usuario'], 500);
        }
    }

    public function desactivateUser(Request $request, User $user) {
        try 
        {
            $user->active = 0;
            $user->save();
        } 
        catch (\Exception $e) 
        {
            return response()->json(['message' => 'Error al eliminar el usuario'], 500);
        }
    }

    public function reactivate(Request $request, User $user)
    {
        try 
        {
            $user->active = 1;
            $user->save();
        } 
        catch (\Exception $e) 
        {
            return response()->json(['message' => 'Error al reactivar el usuario'], 500);
        }
    }
    
    public function getProviderByNick($nickname, User $user) {
        $currentDay = Carbon::now()->dayOfWeek;
        if ($currentDay == 0) {
            $currentDay = 7;
        }
        $currentUserLat = $user->latitude;
        $currentUserLng = $user->longitude;
        $currentUser = $user;
        $provider = User::with([
                'addresses.roadType', 
                'schedules' => function ($query) use ($currentDay) {
                    $query->where('day', $currentDay); 
                },
                'typeUsers' => function ($query) {
                    $query->whereIn('type_user.id_type_user', [2])->withPivot('type_of_provider');
                },
                'menus' => function ($query) {
                    $query->withCount('launchpack')->whereHas('launchpack');
                },
                'favoriteProviders'
            ])
            ->whereHas('typeUsers', function ($query) {
                $query->whereIn('type_user.id_type_user', [2]);
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
        if ($currentDay == 0) {
            $currentDay = 7;
        }
        $providers = User::with([
            'addresses.roadType', 
            'schedules' => function ($query) use ($currentDay) {
                $query->where('day', $currentDay); 
            },
            'typeUsers' => function ($query) {
                $query->whereIn('type_user.id_type_user', [2])->withPivot('type_of_provider');
            },
            'menus.launchpack',
            'favoriteProviders'
        ])
        ->whereHas('typeUsers', function ($query) {
            $query->whereIn('type_user.id_type_user', [2]);
        })
        ->whereHas('menus', function ($query) {
            $query->has('launchpack');
        })
        ->get();

        $providers->each(function ($provider) use ($user) {
            $provider->distance = $this->haversineDistance($user->latitude, $user->longitude, $provider->latitude, $provider->longitude);
            $provider->is_favorite = $user->favoriteProviders->contains($provider->id_user);
        });

        $providers = $providers->sortBy('distance');

        return UserResource::collection($providers);
    }
    public function getBetterProviders(User $user) {
        $currentDay = Carbon::now()->dayOfWeek;
        if ($currentDay == 0) {
            $currentDay = 7;
        }
        $providers  = User::with([
            'addresses.roadType', 
            'schedules' => function ($query) use ($currentDay) {
                $query->where('day', $currentDay); 
            },
            'typeUsers' => function ($query) {
                $query->whereIn('type_user.id_type_user', [2])->withPivot('type_of_provider');
            },
            'menus.launchpack',
            'favoriteProviders'
        ])
        ->whereHas('typeUsers', function ($query) {
            $query->whereIn('type_user.id_type_user', [2]);
        })
        ->whereHas('menus', function ($query) {
            $query->has('launchpack');
        })
        ->get();
    
        $providers->each(function ($provider) use ($user) {
            $provider->distance = $this->haversineDistance($user->latitude, $user->longitude, $provider->latitude, $provider->longitude);
            $provider->is_favorite = $user->favoriteProviders->pluck('id_user')->contains($provider->id_user);
            $provider->favorite_count = $provider->favoriteProviders()->count();
        });
    
        $providers = $providers->sortByDesc('favorite_count');
    
        return UserResource::collection($providers);
    }
    public function getFavouritesProviders(User $user) {
        $currentDay = Carbon::now()->dayOfWeek;
        if ($currentDay == 0) {
            $currentDay = 7;
        }
        $currentUserLat = $user->latitude;
        $currentUserLng = $user->longitude;

        $providers = User::with([
            'addresses.roadType', 
            'schedules' => function ($query) use ($currentDay) {
                $query->where('day', $currentDay); 
            },
            'typeUsers' => function ($query) {
                $query->whereIn('type_user.id_type_user', [2])->withPivot('type_of_provider');
            },
            'menus.launchpack',
            'favoriteProviders'
        ])
        ->whereHas('typeUsers', function ($query) {
            $query->whereIn('type_user.id_type_user', [2]);
        })
        ->whereHas('menus', function ($query) {
            $query->has('launchpack');
        })
        ->get();

        $favoriteProviders = $providers->filter(function ($provider) use ($user) {
            return $user->favoriteProviders->pluck('id_user')->contains($provider->id_user);
        });
        
        $favoriteProviders->each(function ($provider) use ($currentUserLat, $currentUserLng, $user) {
            $provider->distance = $this->haversineDistance($currentUserLat, $currentUserLng, $provider->latitude, $provider->longitude);
            $provider->is_favorite = true;
        });
    
        $favoriteProviders = $favoriteProviders->sortBy('distance');
    
        return UserResource::collection($favoriteProviders);
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

    public function reserveMarkers(User $user, $menuid)
    {
        $currentUser = $user;

        // Obtener el proveedor asociado al menu
        $provider = Menu::findOrFail($menuid)->user;
        $markers = Marker::with(['history' => function ($query) {
            $query->orderBy('timestamp', 'desc');
        }, 'history.state'])->get();
    
        return [
            'provider' => $provider,
            'markers' => $markers,
            'user' => $currentUser
        ];
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

    public function getUsersNums(Request $request) {
        $ridersNum = 0;
        $providersNum = 0;

        $users = User::with('typeUsers')->where('active', 1)->get();  

        foreach ($users as $user) {
            if ($user->typeUsers->contains('id_type_user', 1)) {
                $ridersNum++;
            } else if ($user->typeUsers->contains('id_type_user', 2)) {
                $providersNum++;
            }
        }

        return response()->json([
            'riders' => $ridersNum,
            'providers' => $providersNum
        ]);
    }

    public function getNumUsersByMonth(Request $request, $idUser) {

        $riders = User::with('typeUsers')->where('active', 1)->whereHas('typeUsers', function ($query) use ($idUser){
            $query->where('user_type_user.id_type_user', $idUser);
        })->get();

        $riders = $riders->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('Y-m');
        })->map(function ($group) {
            return $group->count();
        })->sortBy(function ($value, $key) {
            return $key;
        });

        $totalUsers = 0;
        foreach ($riders as $key => $value) {
            $riders[$key] = $totalUsers += $value;
        }
        return response()->json([$riders]);
    }

    public function getNumUsersByType(Type_User $typeUser) {
        $users = User::with('typeUsers')->where('active', 1)->whereHas('typeUsers', function ($query) use ($typeUser){
            $query->where('user_type_user.id_type_user', $typeUser->id_type_user);
        })->get();
        return $users->count();
    }

    public function doSuggest($latitude, $longitude) {
        $providers = User::where('active', 1)
        ->whereHas('menus', function ($query) {
            $query->has('launchpack');
        })
        ->whereHas('typeUsers', function($query){
            $query->where('user_type_user.id_type_user', 2);
        })
        ->get();
        $nearestProvider = null;
        $nearestProviderDistance = PHP_INT_MAX;
        foreach ($providers as $provider) {
            $distance = $this->haversineDistance($latitude, $longitude, $provider->latitude, $provider->longitude);

            if ($distance < $nearestProviderDistance) {
                $nearestProvider = $provider;
                $nearestProviderDistance = $distance;
            }
        }
        $markers = Marker::where('num_people_not_eat', '>', 0)->get();
        $nearest_homeless = null;
        $nearestMarkerDistance = PHP_INT_MAX;
        foreach ($markers as $marker) {
            $distance = $this->haversineDistance($nearestProvider->latitude, $nearestProvider->longitude, $marker->latitude, $marker->longitude);
    
            if ($distance < $nearestMarkerDistance) {
                $nearest_homeless = $marker;
                $nearestMarkerDistance = $distance;
            }
        }

        return [
            'nearest_provider' => new UserResource($nearestProvider),
            'nearest_marker' => new MarkerResource($nearest_homeless)
        ];
    }
    public function updateUserData(Request $request) {
        DB::beginTransaction();
    
        try {
            $userInput = $request->input('user');
            $directionsInput = $request->input('adresses');
            $schedulesInput = $request->input('schedules');
    
            $userDB = User::find($userInput['id_user']);
            if (!$userDB) {
                throw new \Exception('User not found');
            }
    
            // Update user email
            $userDB->email = $userInput['email'];
            $userDB->save();
            
            // Update or create addresses
            $userDB->addresses()->delete();
            foreach ($directionsInput as $direction) {
                $newDirection = [
                    'city' => $direction['city'],
                    'country' => $direction['country'],
                    'name' => $direction['name'],
                    'cp' => $direction['cp'],
                    'number' => $direction['number'],
                    'floor' => $direction['floor'],
                    'door' => $direction['door'],
                    'id_road' => $direction['id_road'],
                    'id_user' => $userDB->id_user,
                ];
                $userDB->addresses()->create($newDirection);
            }
    
            $userDB->schedules()->delete();
            foreach ($schedulesInput as $schedule) {
                $startTime = Carbon::parse($schedule['start_time'])->format('H:i:s');
                // Convertir finish_time de datetime a time
                $finishTime = Carbon::parse($schedule['finish_time'])->format('H:i:s');

                // Crear un nuevo horario con los valores convertidos
                $newSchedule = [
                    'day' => $schedule['day'],
                    'shift' => $schedule['shift'],
                    'start_time' => $startTime,
                    'finish_time' => $finishTime,
                    'id_user' => $userDB->id,
                ];

                // Insertar el nuevo horario en la base de datos
                $userDB->schedules()->create($newSchedule);
            }
    
            DB::commit();
    
            return response()->json(['message' => 'User data updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function login(Request $request) {
        try {
            $nickname = $request->input('nickname');
            $password = $request->input('password');

            
            // where tipo usuario (botones)

            // compeobar tipo usuario
            
            $user = User::with('typeUsers')
            ->where('nickname', '=', $nickname)
            // where tipo usuario
            ->first();
            if (isset($user) && Hash::check($password, $user->password)) {
                // Suponiendo que 'type' es el atributo que determina el tipo de usuario
                Auth::login($user);
                return $user;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function logout(Request $request) {
        Auth::logout();
        return response()->json(['message' => 'User logged out'], 200);
    }
    public function changePassword(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'oldPassword' => 'required|string',
            'newPassword' => 'required|string',
            'newPassword2' => 'required|string|same:newPassword',
        ]);

        if (!Hash::check($validatedData['oldPassword'], $user->password)) {
            return response()->json(['error' => 'La contraseña antigua no coincide'], 400);
        }

        if ($validatedData['newPassword'] !== $validatedData['newPassword2']) {
            return response()->json(['error' => 'Las nuevas contraseñas no coinciden'], 400);
        }

        $user->password = Hash::make($validatedData['newPassword']);
        $user->save();

        return response()->json(['message' => 'Contraseña cambiada correctamente'], 200);
    }

    
}

