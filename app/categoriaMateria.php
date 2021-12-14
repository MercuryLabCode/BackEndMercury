<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categoriaMateria extends Model
{
    protected $table = 't_estado_categoria';
    protected $primaryKey = 'Catalogo_Estado_categoria';
    protected $keyType = 'string';

    const CREATED_AT = 'Created_Date';
    const UPDATED_AT = 'Updated_Date';

    public function User_ID()
    {
        return $this->belongsTo('App\t_user','User_ID');
    }
}
