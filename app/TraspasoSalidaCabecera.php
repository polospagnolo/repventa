<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TraspasoSalidaCabecera extends Model
{
    protected $table = 'man_traspaso_salida_cabecera';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'descripcion',
        'user_id',
    ];

    protected $guarded = [
        'id',
    ];
}
