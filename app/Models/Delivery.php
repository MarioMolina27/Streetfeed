<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $table = 'delivery';
    // protected $primaryKey = 'id';
    // protected $incrementing= true;
    // protected $keyType= 'string';
    public $timestamps= false;

    public function state()
    {
        return $this->belongsTo(Delivery_State::class, 'id_state');
    }

    public function marker()
    {
        return $this->belongsTo(Marker::class, 'id_marker');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }
}