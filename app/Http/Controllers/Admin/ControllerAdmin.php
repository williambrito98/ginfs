<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotaFiscal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ControllerAdmin extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $currentUserId = Auth::user()->id;
        $user = User::find($currentUserId)->roles[0]->nome;

        if($user == 'cliente'){
            $listaDeSolicitacoes = NotaFiscal::where('user_id', '=', $currentUserId)->orderBy('id')->limit(8)->get();
            return view('admin.dashboard', compact('listaDeSolicitacoes'));
        }

        $listaDeSolicitacoes = NotaFiscal::orderBy('id')->limit(8)->get();
        return view('admin.dashboard', compact('listaDeSolicitacoes'));

    }
}
