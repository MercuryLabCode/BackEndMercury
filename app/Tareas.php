<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tareas extends Model
{
    protected $table = 't_tareas';
    protected $primaryKey = 'Tarea_id';
    const CREATED_AT = 'Created_Date';
    const UPDATED_AT = 'Updated_Date';

    public function id_user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
    public function cliente()
    {
        return $this->belongsTo('App\Clientes', 'op_venta');
    }

    public function id_estado()
    {
        return $this->belongsTo('App\estado_tarea', 'id_estado');
    }


}
