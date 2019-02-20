<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TraspasoSalidaLinea extends Model
{
    protected $table = 'man_traspaso_salida_lineas';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'traspaso_id',
        'articuloaecoc_id',
        'cantidad'
    ];

    protected $guarded = [
        'id',
    ];

    public function aecoc()
    {
        return $this->belongsTo('App\ArticuloAecoc','articuloaecoc_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function traspaso()
    {
        return $this->belongsTo('App\TraspasoSalidaCabecera','traspaso_id');
    }
}
