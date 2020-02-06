<?php
use App\Country;
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

Route::get('/', function () {
    $countries = Country::orderBy('name','ASC')->get();
    if(Auth::check()==true && Auth::user()->status == 'activo'){
        if(Auth::user()->role_id == 1){
            return redirect()->route('voyager.dashboard');
        }else{
            return redirect()->route('clients.index');
        }
    } else {
        return view('login',compact('countries'));
    }
})->name('inicio');


Route::post('logout','MediacamController@logout')->name('mediacam.logout');

Route::group(['prefix' => 'mediacam'], function () {
    Voyager::routes();
    Route::group(['middleware' => ['auth']], function(){
        Route::get('/profileuser','MediacamController@profile')->name('mediacam.profile');
        Route::resource('clients','PantallaController');
        Route::resource('trafico','TraficoController');
        Route::get('/contactos','MediacamController@contactos')->name('mediacam.contacts');
        Route::post('/envio','MediacamController@contactar')->name('mediacam.contacto');
        Route::post('pantalla','PantallaController@changescren')->name('pantallas.change');
    });
});
