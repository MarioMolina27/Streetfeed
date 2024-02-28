<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $table = 'schedule';
    // protected $primaryKey = 'id';
    // protected $incrementing= true;
    // protected $keyType= 'string';
    public $timestamps= false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
