<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marker_State extends Model
{
    use HasFactory;
    protected $table = 'marker_state';
    protected $primaryKey = 'id_state';
    // protected $incrementing= true;
    // protected $keyType= 'string';
    public $timestamps= false;

    public function histories()
    {
        return $this->hasMany(Marker_History::class, 'id_state');
    }
}
