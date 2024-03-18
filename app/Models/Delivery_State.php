<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery_State extends Model
{
    use HasFactory;
    protected $table = 'delivery_state';
    protected $primaryKey = 'id_state';
    // protected $incrementing= true;
    // protected $keyType= 'string';
    public $timestamps= false;

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'id');
    }
}
