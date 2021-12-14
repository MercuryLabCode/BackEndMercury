<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class proyecto extends Model
{
    protected $table = 't_proyecto';
    protected $primaryKey = 'Proyecto_ID';
    protected $keyType = 'string';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
   



    // ────────────────────────────────────────────────────────────────────────────────


    /**
     * Relacion de muchos a uno con la tabla estado_proyecto
     */

    public function Estado_Proyecto()
    {
        return $this->belongsTo('App\estadoProyecto','Estado_Proyecto');
    }

    public function User_ID()
    {
        return $this->belongsTo('App\User','User_ID');
    }


    /**
     * Relacion de uno a muchos con la tabla torre
     */

    public function torre()
    {
        return $this->hasMany('App\Torre');
    }

    /**
     * Get all of the comments for the proyecto
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inmueble()
    {
        return $this->hasMany( 'App\Inmueble');
    }

}
