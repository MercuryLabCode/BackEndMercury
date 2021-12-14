<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cotizaciones extends Model
{
    protected $table = 't_cotizaciones';
    protected $primaryKey = 'PRIMARY';
    protected $keyType = 'string';
 const CREATED_AT = 'Created_Date';
    const UPDATED_AT = 'Updated_Date';

    public function Cliente_ID()
    {

        return $this->belongsTo('App\Clientes', 'Cliente_ID');
    }
    public function id_user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function id_op_venta()
    {
        return $this->belongsTo('App\Oportunidad_venta', 'id_op_venta');
    }

    public function fechaCotizacion()
    {
        return $this->hasMany('App\fechaPagosCotizacion');
    }
    public function id_estado()
    {
        return $this->belongsTo('App\estadoCotizacion', 'id_estado');
    }
}
