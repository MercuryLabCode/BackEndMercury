<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estado_cuota_separacion extends Model
{
    protected $table = 't_estado_cuota_separacion';
    protected $primaryKey = 'Catalogo_Estado_Separacion';
    protected $keyType = 'string';

    const CREATED_AT = 'Created_Date';
    const UPDATED_AT = 'Updated_Date';
}
