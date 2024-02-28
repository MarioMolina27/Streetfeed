<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_User extends Model
{
    use HasFactory;
    protected $table = 'type_user';
    // protected $primaryKey = 'id';
    // protected $incrementing= true;
    // protected $keyType= 'string';
    public $timestamps= false;

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('type_of_provider');
    }
}
