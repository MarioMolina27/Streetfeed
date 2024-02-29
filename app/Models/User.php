<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'user';
    protected $primaryKey = 'id_user';
    // protected $incrementing= true;
    // protected $keyType= 'string';
    public $timestamps= false;

    public function addresses()
    {
        return $this->hasMany(Adress::class, 'id_user');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'id_user');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'id_user');
    }

    public function typeUsers()
    {
        return $this->belongsToMany(Type_User::class, 'user_type_user', 'id_user', 'id_type_user')->withPivot('type_of_provider');
    }

    public function favoriteProviders()
    {
        return $this->belongsToMany(User::class, 'user_favorites', 'id_user', 'id_provider_fav');
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'id_user');
    }
    public function menus()
    {
        return $this->hasMany(Menu::class, 'id_user');
    }
}
