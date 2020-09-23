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

Route::get('/', function () {
    return view('welcome');
});

//Rotas para a aeronave ----------------------------------------------------------------------------
Route::get('aeronaves', 'AeronaveController@index')->name('planes.index');
Route::get('aeronaves/create', 'AeronaveController@create')->name('planes.create');
Route::post('aeronaves', 'AeronaveController@store')->name('planes.store');
Route::get('aeronaves/{plane}/edit', 'AeronaveController@edit')->name('planes.edit');
Route::put('aeronaves/{plane}', 'AeronaveController@update')->name('planes.update');
Route::delete('aeronaves/{plane}', 'AeronaveController@destroy')->name('planes.destroy');

Route::get('aeronaves/{plane}/precos_tempos', 'AeronaveController@getMapping')->name('planes.times');

//Rotas para as aeronaves e pilotos ----------------------------------------------------------------

Route::get('/aeronaves/{plane}/pilotos', 'AeronaveController@mostrarPilotos')
	->name('pilotos.index');
Route::get('aeronaves/{plane}/pilotos/add', 'AeronaveController@addPiloto')
	->name('pilotos.add');
Route::post('aeronaves/{plane}/pilotos/{user}', 'AeronaveController@storePiloto')
	->name('pilotos.store');
Route::delete('/aeronaves/{plane}/pilotos/{piloto}', 'AeronaveController@deletePiloto')
	->name('pilotos.delete');

//Rota para desafio (US33)

Route::get('/aeronaves/{plane}/linha_temporal', 'AeronaveController@linhaGrafico')
	->name('planes.graph');

Route::post('/aeronaves/{plane}/linha_temporal', 'AeronaveController@makeGraph')
	->name('planes.makeGraph');



//Rotas para Movimentos -----------------------------------------------------------------------------
Route::get('movimentos/estatisticas','MovimentosController@estatisticas')
	->name('movimentos.estatisticas');

Route::post('movimentos/estatisticas', 'MovimentosController@getEstatisticas')
	->name('movimentos.estatisticasPost');

Route::post('movimentos/index', 'MovimentosController@getFilter')
	->name('movimentos.indexPost');

Route::resource('/movimentos', 'MovimentosController');


Route::get('/home', 'HomeController@index')->name('home');

// //Rotas para Socios:
Route::get('socios/create', 'UserController@create')->name('users.create');

Route::get('socios/{user}', 'UserController@show')->name('users.show');

Route::get('socios', 'UserController@index')->name('users.index');
//Criar:
Route::post('socios', 'UserController@store')->name('users.store');
//Editar
Route::get('socios/{user}/edit', 'UserController@edit')->name('users.edit');
Route::put('socios/{user}', 'UserController@update')->name('users.update');
//Apagar
Route::delete('socios/{user}', 'UserController@destroy')->name('users.destroy');
//Quotas
Route::patch('socios/{user}/quota' , 'UserController@quotaPaga')->name('users.quotaPaga');
Route::patch('socios/reset_quotas', 'UserController@reset_quotas')->name('users.reset_quotas');
//Ativacoes
Route::patch('/socios/{user}/ativo', 'UserController@ativarOuDesaticarSocio')
	->name('users.ativarOuDesaticarSocio');
Route::patch('/socios/desativar_sem_quotas', 'UserController@desaticarSociosSemQuotas')
	->name('users.desaticarSociosSemQuotas');
//Mail
Route::post('/socios/{user}/send_reactivate_mail', 'UserController@reenviarMailAtivacao')
	->name('users.reenviarMailAtivacao');
//Imagens
Route::get('/socios/{piloto}/certificado', 'UserController@getCertificado')
	->name('users.getCertificado');
Route::get('/socios/{piloto}/licenca', 'UserController@getLicenca')->name('users.getLicenca');
//Rota das autenticações
Route::get('/password','HomeController@showChangePasswordForm');
Route::patch('/password','HomeController@changePassword')->name('changePassword');


Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Auth::routes([ 'register' => false, 'verify' => true ]);
