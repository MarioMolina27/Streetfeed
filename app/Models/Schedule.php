<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $table = 'schedule';
    protected $primaryKey = 'id_schedule';
    // protected $incrementing= true;
    // protected $keyType= 'string';
    public $timestamps= false;

    protected $fillable = [
        'id_schedule',
        'day',
        'shift',
        'start_time',
        'finish_time',
        'id_user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
