<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_Road extends Model
{
    use HasFactory;
    protected $table = 'type_road';
    // protected $primaryKey = 'id';
    // protected $incrementing= true;
    // protected $keyType= 'string';
    public $timestamps= false;

    public function addresses()
    {
        return $this->hasMany(Adress::class, 'id_road');
    }
}
