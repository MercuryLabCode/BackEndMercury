<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    
    use Notifiable;
    protected $table = 't_users';
    protected $primaryKey = 'User_ID';
    const CREATED_AT = 'Created_Date';
    const UPDATED_AT = 'Updated_Date';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'User_Name', 'User_Email', 'User_Contrasena	',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'User_Contrasena', 'Remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Perfil_User(){
        return $this->belongsTo('App\Perfil','Perfil_User'); 
    }

    public function obras(){

        return $this->hasMany('App\Obras');
    }

    public function user_cotizaciones(){
    
        return $this->hasMany('App\cotizaciones');

    }

    public function proveedor()
    {
        return $this->hasMany('App\Proveedor');
    }
}
