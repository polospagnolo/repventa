<?php

namespace App\Jobs;

use App\TraspasoSalidaCabecera;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CreateTxts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $traspaso = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->traspaso = $this->createTraspaso();
        return $this->chain($this->generateJobs());

    }

    public function generateJobs()
    {
        $jobs = new Collection();

        $sales = DB::table('sales_repositions')
            ->select(DB::raw(' sum(cantidad) as sum,almacen'))
            ->groupBy('almacen')
            //->groupBy('aecoc')
            ->get();

        foreach ($sales as $sale)
        {
            $jobs->push(new CreateTxt($sale,$this->traspaso));
        }
        $jobs->push(new \App\Jobs\SendEmail());
        return $jobs;
    }

    public function createTraspaso()
    {
        $traspaso = New TraspasoSalidaCabecera;
        $traspaso->descripcion = "Reposición de venta del ".date('d-m-Y');
        $traspaso->user_id = 6339;
        $traspaso->save();
        return $traspaso;
    }
}
