<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inmueble extends Model
{
    protected $table = 't_unidades';
    protected $primaryKey = 'id_unidad';
    protected $keyType = 'string';

    public function User_ID()
    {
       
        return $this->belongsTo('App\User', 'User_ID');
    }

    public function Tipo_Inmueble()
    {
        return $this->belongsTo('App\tipo_inmueble','Tipo_Inmueble');
    }


    public function Torre_Name()
    {
        return  $this->belongsTo('App\Torre','Torre_Name');
    }

    /**
     * Get the user that owns the Inmueble
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Proyecto_ID()
    {
        return $this->belongsTo('App\proyecto', 'Proyecto_ID');
    }





}
