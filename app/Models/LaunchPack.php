<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Launch_Pack extends Model
{
    use HasFactory;
    protected $table = 'launchpack';
    // protected $primaryKey = 'id';
    // protected $incrementing= true;
    // protected $keyType= 'string';
    public $timestamps= false;

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }
}
