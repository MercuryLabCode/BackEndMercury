<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fechaPagosCotizacion extends Model
{
    protected $table = 't_pagos_cotizaciones';
    
    protected $primaryKey = 'PRIMARY';
    


    public function id_cotizacion()
    {
        return $this->belongsTo('App\cotizaciones','id_cotizacion');
    }
    public function estado_id()
    {
        return $this->belongsTo('App\estadoFechaPagos','estado_id');
    }

}
