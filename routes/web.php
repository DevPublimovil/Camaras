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
    if(Auth::check())
    {
        return redirect()->route('clients.index');
    }
    else
    {
        return view('login');
    }
})->name('inicio');

Auth::routes(['register' => false]);

Route::post('logout','MediacamController@logout')->name('mediacam.logout');


Route::group(['prefix' => 'mediacam'], function () {
    Voyager::routes();
    Route::group(['middleware' => ['auth']], function(){
        Route::get('/profileuser','MediacamController@profile')->name('mediacam.profile');
        Route::resource('/clients','PantallaController');
        Route::resource('/trafico','TraficoController');
        Route::resource('/apipantallas', 'ApiPantallasController');
        Route::resource('/pautas', 'PautasController');
        Route::post('/backup', 'MediacamController@downloadBackup')->name('download.backup');
        Route::get('/backupday', 'MediacamController@listDays')->name('list.daysbackup');
        Route::get('/listpautas/{id}', 'PautasController@listpautas');
        Route::resource('/ventaspublimovil','VentasController');
        Route::get('/medios', 'MediaController@index')->name('medios.index');
        Route::post('/medios', 'MediaController@store')->name('medios.store');
        Route::post('/medios/files', 'MediaController@files')->name('medios.files');
        Route::get('/apiventas', 'VentasController@apiventas')->name('ventaspublimovil.datatables');
        Route::get('/contactos','MediacamController@contactos')->name('mediacam.contacts');
        Route::post('/envio','MediacamController@contactar')->name('mediacam.contacto');
        Route::post('pantalla','PantallaController@changescren')->name('pantallas.change');
        Route::post('/vistas/store', 'VisualizacionesController@store')->name('vistas.store');
        Route::get('/vistas/{date}/{country}', 'VisualizacionesController@index')->name('vistas.index');
        Route::get('/vistas/day/{date}/{country}', 'VisualizacionesController@graficoDay')->name('vistas.day');
        Route::get('/vistas/month/{date}/{country}', 'VisualizacionesController@graficomonth')->name('vistas.month');
        Route::get('/vistas/year/{date}/{country}', 'VisualizacionesController@graficoYear')->name('vistas.year');
        Route::get('/apigrafico', 'VisualizacionesController@apigrafico')->name('vistas.apiindex');
        Route::get('/camara/{ip}', 'CamaraController@vercamara')->name('camera.index');
        Route::post('/reportes', 'ReportesController@generarReporte')->name('reportes.store');
    });
});
