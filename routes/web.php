<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//
use App\Imports\SalesImport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    /*   $user = \App\User::find(6339);
       dd($user->hasRole(['super-admin']));*/
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/import', function () {
    if(file_exists(public_path('txt/Traspaso.txt')))
    {
        unlink(public_path('txt/Traspaso.txt'));
    }

    \App\SalesReposition::truncate();
       Excel::queueImport(new SalesImport, 'Libro1.xlsx')
       ->chain([new App\Jobs\CreateTxts()]);

       return 'Se esta procesando';

});
