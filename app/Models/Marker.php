<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    use HasFactory;
    protected $table = 'marker';
    protected $primaryKey = 'id_marker';
    // protected $incrementing= true;
    // protected $keyType= 'string';
    public $timestamps= false;

    public function history()
    {
        return $this->hasMany(Marker_History::class, 'id_marker');
    }
}
