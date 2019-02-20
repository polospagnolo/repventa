<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ArticuloAecoc extends Model
{
    protected $table = 'man_articulo_aecoc';

    protected $primaryKey = 'idarticuloaecoc';

    public $timestamps = true;

    protected $fillable = [
        'articulocolor_id',
        'talla_id',
        'aecoc',
        'precio',
        'stock',
        'created_user',
        'updated_user',
    ];

    protected $guarded = [
        'idarticuloaecoc',
    ];
    /*public function talla()
    {
        return $this->belongsTo('App\Talla', 'talla_id')->orderBy('idtalla','asc');
    }
    public function color()
    {
        return $this->belongsTo('App\ArticuloColor', 'articulocolor_id')->with('imagen','principal','articulo');
    }*/




    public static function findByAecoc($aecoc)
    {
        return static::whereAecoc($aecoc)->first();
    }

}


