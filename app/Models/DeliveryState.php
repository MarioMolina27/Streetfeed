<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery_Sate extends Model
{
    use HasFactory;
    protected $table = 'delivery_state';
    // protected $primaryKey = 'id';
    // protected $incrementing= true;
    // protected $keyType= 'string';
    public $timestamps= false;

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'id_state');
    }
}
