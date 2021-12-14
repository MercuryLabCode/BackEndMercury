<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tIdentificacion extends Model
{
    protected $table = 't_tipo_identificacion';
    protected $primaryKey = 'ID_Ident';
    const CREATED_AT = 'Created_Date';
    const UPDATED_AT = 'Updated_Date';



    
}
