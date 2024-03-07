<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marker_History extends Model
{
    use HasFactory;
    protected $table = 'marker_history';
    // protected $primaryKey = 'id';
    // protected $incrementing= true;
    // protected $keyType= 'string';
    public $timestamps= false;

    public function marker()
    {
        return $this->belongsTo(Marker::class, 'id_marker');
    }

    public function state()
    {
        return $this->belongsTo(Marker_State::class, 'id_state');
    }
}
