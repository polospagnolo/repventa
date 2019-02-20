<?php

namespace App\Http\Controllers;

use App\Imports\SalesImport;
use App\Jobs\CreateTxts;
use App\SalesReposition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function import()
    {
        return view('home');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx'
        ]);



        if (file_exists(public_path('txt/Traspaso.txt'))) {
            unlink(public_path('txt/Traspaso.txt'));
        }

        SalesReposition::truncate();
        Excel::queueImport(new SalesImport, $request->file('file'))
            ->chain([new CreateTxts()]);

        Session::put('status', 'Se esta procesando. Recibirá un email con el .txt');
        return redirect()->route('home');
    }
}
