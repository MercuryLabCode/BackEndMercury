<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Proveedor extends Model
{
    protected $table = 't_proveedores';
    protected $primaryKey = 'No_Documento_Prov';
    const CREATED_AT = 'Created_Date';
    const UPDATED_AT = 'Updated_Date';

    public function Tipo_Documento_Prov()
    {

        return $this->belongsTo('App\tIdentificacion', 'Tipo_Documento_Prov');
    }

    public function User_ID()
    {
        return $this->belongsTo('App\User','User_ID');
    }

    public function Ciudad($Ciudad)
    {
         $data = DB::select(

        'SELECT *
        
        FROM t_ciudades_colombia
        WHERE Municipio = ? and marca = ?',
        [$Ciudad]

        );


        return $data;
    }

    public function producto()
    {
        return $this->hasMany('App\Producto');
    }
}
