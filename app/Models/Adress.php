<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    use HasFactory;
    protected $table = 'adress';
    protected $primaryKey = 'id_adress';
    // protected $incrementing= true;
    // protected $keyType= 'string';
    public $timestamps= false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function roadType()
    {
        return $this->belongsTo(Type_Road::class, 'id_road');
    }
}
