<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    // protected $incrementing= true;
    // protected $keyType= 'string';
    public $timestamps= false;

    public function launchpack()
    {
        return $this->hasMany(Launch_Pack::class, 'id_menu');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
