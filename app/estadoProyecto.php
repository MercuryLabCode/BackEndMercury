<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estadoProyecto extends Model
{
    protected $table = 't_estado_proyectos';
    protected $primaryKey = 'Catalogo_Estado_Proy';
    protected $keyType = 'string';

    const CREATED_AT = 'Created_Date';
    const UPDATED_AT = 'Updated_Date';


    public function proyecto()
    {
        return $this->hasMany('App\proyecto');
    }

}
