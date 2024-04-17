<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Models\User;
use App\Models\Launch_Pack;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;




class MenuController extends Controller
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
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Menu $menu)
    {
        //
    }

    public function getMenusfromProvider(User $user){
        $menus = Menu::where('id_user', $user->id_user)
        ->where('active', 1)
        ->with('launchpack')
        ->get();
        return response()->json($menus);
    }
    public function createMenu(Request $request){
        DB::beginTransaction();

        try {
            $menu = new Menu();
            $menu->id_user = $request->id_user;
            $menu->title = $request->title;
            $menu->first_product = $request->first_product;
            $menu->second_product = $request->second_product;
            $menu->drink_product = $request->drink_product;
            $menu->active = $request->active;
    
            $menu->save();
            $id= $menu->id_menu;
            // $numLauchpack = $request->numLaunchpack;
    
            // if($numLauchpack > 0){
            //     for($i = 0; $i < $numLauchpack; $i++){
            //         $launchpack = new Launch_Pack();
            //         $launchpack->id_menu = $menu->id_menu;
            //         $launchpack->save();
            //     }
            // }
            DB::commit();
            return response()->json(['message' => 'Menu created successfully', 'newId'=> $id], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function updateMenu(Request $request){
        DB::beginTransaction();

        try {
            $id = $request->id_menu;
            $menu = Menu::find($request->id_menu);
            $menu->title = $request->title;
            $menu->first_product = $request->first_product;
            $menu->second_product = $request->second_product;
            $menu->drink_product = $request->drink_product;
            $menu->active = $request->active;
    
            $menu->save();
            
            // $numLauchpack = $request->numLaunchpack;
    
            // if($numLauchpack > 0){
            //     $launchpacks = Launch_Pack::where('id_menu', $menu->id_menu)->get();
            //     foreach($launchpacks as $launchpack){
            //         $launchpack->delete();
            //     }
            //     for($i = 0; $i < $numLauchpack; $i++){
            //         $launchpack = new Launch_Pack();
            //         $launchpack->id_menu = $menu->id_menu;
            //         $launchpack->save();
            //     }
            // }
            DB::commit();
            return response()->json(['message' => 'Menu updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function updateLaunchPack(Request $request,Menu $menu){
        $numLauchpack = $request->numLaunchpack;
        $menu->launchpack()->delete();
        for($i = 0; $i < $numLauchpack; $i++){
            $launchpack = new Launch_Pack();
            $launchpack->id_menu = $menu->id_menu;
            $launchpack->save();
        }
    }

    public function deleteMenu(Request $request, Menu $menu){

        try {
            $menu = Menu::find($menu->id_menu);
            $menu->active = 0;
            $menu->save();
            return response()->json(['message' => 'Menu deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
