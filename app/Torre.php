<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Torre extends Model
{
    protected $table = 't_torre';
    protected $primaryKey = 'PRIMARY';
    

    public function id_proyecto()
    {
       return $this->belongsTo('App\proyecto','id_proyecto');
    }

    public function id_user()
    {
       return $this->belongsTo('App\user','id_user');
    }

    //RELACION UNO AMUCHOS

}
