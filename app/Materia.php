<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $table = 't_materiales';
    protected $primaryKey = 'Codigo_ID';
    protected $keyType = 'string';

    const CREATED_AT = 'Created_Date';
    const UPDATED_AT = 'Updated_Date';
    public function  Medida()
    {
        return $this->belongsTo('App\medida','Medida');
    }

    public function Categoria(){

        return $this->belongsTo('App\categoriaMateria','Categoria');
    }

    public function No_Documento_Prov()
    {
        return $this->belongsTo('App\Proveedor','No_Documento_Prov');
    }
    public function 	User_ID()
    {
        return $this->belongsTo('App\User','User_ID');
    }
}
