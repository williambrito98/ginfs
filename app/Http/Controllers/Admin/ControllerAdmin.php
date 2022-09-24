<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotaFiscal;


class ControllerAdmin extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $listaDeSolicitacoes = NotaFiscal::orderBy('data_emissao')->limit(8)->get();
        return view('admin.dashboard', compact('listaDeSolicitacoes'));
    }
}
