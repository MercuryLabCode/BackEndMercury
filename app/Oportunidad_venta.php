<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Oportunidad_venta extends Model
{
    protected $table = 't_oportunidad_venta';
    protected $primaryKey = 'Op_Venta_ID';
    protected $keyType = 'string';

    const CREATED_AT = 'Created_Date';
    const UPDATED_AT = 'Updated_Date';
    //-----------Relaciónes de muchos a uno--------------------


    /**
     *
     */
    public function Cliente_ID(){

        
        return $this->belongsTo('App\Clientes','Cliente_ID');
    }
    /**
     *
     */
    public function Unidad_ID()
    {


        return $this->belongsTo('App\Inmueble','Unidad_ID');
    }

    /**
     *
     */

    public function estado_id()
    {
        return $this->belongsTo('App\Estado_Op','estado_id');
    }



    //-----------Relaciónes de uno a muchos--------------------

    /**
     *
     */
    public function op_venta_cotizacion()
    {
        return $this->hasMany('App\cotizaciones');
    }

}
