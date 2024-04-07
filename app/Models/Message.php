<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $table = 'messages';
    protected $primaryKey = 'id_message';
    // protected $incrementing= true;
    // protected $keyType= 'string';
    public $timestamps= false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
