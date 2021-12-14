<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class medida extends Model
{
    

    protected $table = 't_estado_unidades';
    protected $primaryKey = 'Catalogo_Estado_Uni';
    protected $keyType = 'string';

    const CREATED_AT = 'Created_Date';
    const UPDATED_AT = 'Updated_Date';

    public function User_ID()
    {
        return $this->belongsTo('App\t_user','User_ID');
    }
}
