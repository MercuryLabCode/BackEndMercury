<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 't_clientes';

    protected $primaryKey = 'Cliente_ID';
protected $keyType = 'string';
    const CREATED_AT = 'Created_Date';
    const UPDATED_AT = 'Updated_Date';


    public function productos(){
        return $this->hasMany('App\Producto');
    }

    public function Tipo_Documento_Cli()
    {
        return $this->belongsTo('App\tIdentificacion','Tipo_Documento_Cli');
    }

     public function tarea()
    {
       return $this->hasMany('App\Tareas');
    }

     public function clienteCotizacion()
    {
      return $this->hasMany('App\cotizaciones');
    }

    public function id_n_estudio()
    {
        return $this->belongsTo('App\nivelEstudios','id_n_estudio');
    }

}
