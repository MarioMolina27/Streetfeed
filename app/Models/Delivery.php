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
        return $this->belongsTo('App\DeliveryState', 'id_state');
    }

    public function marker()
    {
        return $this->belongsTo('App\Marker', 'id_marker');
    }
}
