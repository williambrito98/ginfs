<?php

use App\Http\Controllers\Admin\ControllerAdmin;
use App\Http\Controllers\Admin\ControllerPermission;
use App\Http\Controllers\Admin\ControllerRoles;
use App\Http\Controllers\Admin\ControllerUser;
use App\Http\Controllers\Admin\TomadoresController;
use App\Http\Controllers\Admin\ControllerServicos;
use App\Http\Controllers\Admin\ControllerFaturamentoClientes;
use App\Http\Controllers\Admin\ControllerFechamentoMensal;
use App\Http\Controllers\Admin\ControllerFormulas;
use App\Http\Controllers\Admin\ControllerClientes;
use App\Http\Controllers\Admin\NotaFiscalController;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [ControllerAdmin::class, 'index'])->name('dashboard');

    Route::delete('/papeis/destroy', [ControllerRoles::class, 'destroy'])->name('papeis.destroy');

    Route::resource('/papeis', ControllerRoles::class)->only(['index', 'create', 'store', 'update', 'edit']);

    Route::delete('/usuarios/destroy', [ControllerUser::class, 'destroy'])->name('usuarios.destroy');

    Route::resource('/usuarios', ControllerUser::class)->only(['index', 'create', 'store', 'update', 'edit', 'show']);

    Route::get('/papeis/permissoes/{id}', [ControllerRoles::class, 'permissions'])->name('papeis.permissoes');
    Route::post('/papeis/permissoes/{permission}', [ControllerRoles::class, 'permissionsStore'])->name('papeis.permissoes.store');
    Route::delete('/papeis/permissoes/destroy', [ControllerRoles::class, 'permissionsDestroy'])->name('papeis.permissoes.destroy');
    Route::resource('/permissoes', ControllerPermission::class);

    Route::delete('/tomadores/destroy', [TomadoresController::class, 'destroy'])->name('tomadores.destroy');

    Route::resource('/tomadores', TomadoresController::class)->only(['index', 'store', 'edit', 'update', 'create']);

    Route::delete('/servicos/destroy', [ControllerServicos::class, 'destroy'])->name('servicos.destroy');

    Route::delete('/clientes/destroyArray', [ControllerClientes::class, 'destroyArray'])->name('clientes.destroyArray');

    Route::resource('/servicos', ControllerServicos::class)->only(['index', 'store', 'create', 'update', 'edit']);

    Route::get('/clientes/{id}/tomadores', [ControllerClientes::class, 'showTomadores'])->name('clientes.tomadores.index');
    Route::get('/clientes/{id}/faturamento', [ControllerClientes::class, 'showFaturamento'])->name('clientes.faturamento.index');
    Route::post('/clientes/tomadores/store', [ControllerClientes::class, 'storeTomadores'])->name('clientes.tomadores.store');
    Route::delete('/clientes/tomadores/destroy', [ControllerClientes::class, 'destroyRelationTomadorUser'])->name('clientes.tomadores.destroy');

    Route::get('/clientes/{id}/tomador/{idTomador}/details', [ControllerClientes::class, 'detailsTomador'])->name('clientes.tomador.details');

    Route::post('/clientes/tomadores/servicos/store', [ControllerClientes::class, 'storeTomadoresServicos'])->name('clientes.tomadores.servicos.store');

    Route::delete('/clientes/tomadores/servico/destroy', [ControllerClientes::class, 'destroyRelationTomadorServico'])->name('clientes.tomadores.servico.destroy');

    Route::delete('/clientes/destroy', [ControllerClientes::class, 'destroy'])->name('clientes.destroy');

    Route::resource('/clientes', ControllerClientes::class)->only(['index', 'update', 'store', 'edit', 'create']);

    Route::resource('/faturamento', ControllerFaturamentoClientes::class);

    Route::resource('/formulas', ControllerFormulas::class);

    Route::get('/fechamentomensal/{idFaturamento}', [ControllerFechamentoMensal::class, 'encerrarFaturamentoMes'])->name('encerrarFaturamentoMes');
    Route::resource('/fechamentomensal', ControllerFechamentoMensal::class);

    Route::get('/autocomplete', [ControllerFaturamentoClientes::class, 'autocompleteSearch'])->name('autocomplete');

    Route::get('/faturamentoanual/{idCliente}', [ControllerFaturamentoClientes::class, 'getFaturamentoAnualFromCliente'])->name('getFaturamentoAnualFromCliente');


    Route::resource('/solicitacao', NotaFiscalController::class);
    Route::post('/solicitacao/store', [NotaFiscalController::class, 'store'])->name('notafiscal.store');
    Route::get('/solicitacao/{idNotaFiscal}', [NotaFiscalController::class, 'show'])->name('notafiscal.show');
    Route::get('/autocompleteByCliente/{idCliente}', [TomadoresController::class, 'autocompleteSearchByCliente'])->name('autocompleteByCliente');
});


require __DIR__ . '/auth.php';
