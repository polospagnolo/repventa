<?php

namespace App\Jobs;

use App\ArticuloAecoc;
use App\TraspasoSalidaLinea;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class CreateTxt implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $sale;
    protected $almacen = false;
    public $traspaso;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sale,$traspaso)
    {
        //
        $this->sale = $sale;
        $this->traspaso = $traspaso;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$name = $this->sale->almacen . '_' . date('dmYhis');
        $file = fopen(public_path('txt/Traspaso.txt'), "a");


        $aecocs = DB::table('sales_repositions')
            ->select(DB::raw(' sum(cantidad) as sum,aecoc'))
            ->where('almacen', $this->sale->almacen)
            ->groupBy('aecoc')
            //->groupBy('aecoc')
            ->get();
        $minimun = 2;
        foreach ($aecocs as $aecoc) {
            $product = ArticuloAecoc::findByAecoc($aecoc->aecoc);
            if (!$product) {
                continue;
            }
            //El producto no dispone de suficiente stock
            if ($product->stock <= $minimun || $aecoc->sum < 1) {
                continue;
            } else {
                $posibleStock = $product->stock - $minimun;
                if ($posibleStock >= $aecoc->sum) {
                    $stockOut = $aecoc->sum;
                } else {
                    $stockOut = $posibleStock;
                }
                if ($this->almacen == false) {
                    fwrite($file, "{$this->sale->almacen} \r\n");
                    $this->almacen = true;
                }
                $line = new TraspasoSalidaLinea;
                $line->traspaso_id = $this->traspaso->id;
                $line->articuloaecoc_id = $product->idarticuloaecoc;
                $line->cantidad = $stockOut;
                $line->save();
                fwrite($file, $aecoc->aecoc . "        " . $stockOut . "\r\n");
                $product->stock .= $stockOut;
                $product->update();
            }

            //

        }
    }
}
