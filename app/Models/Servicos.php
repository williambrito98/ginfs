<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Servicos extends Model
{
    use HasFactory;


    protected $table = 'servicos';

    protected $fillable = ['codigo', 'nome', 'rentencao_iss'];

    public function users()
    {
        return $this->hasMany(User::class, 'users_servicos');
    }

    public function notaFiscal()
    {
        return $this->belongsTo(NotaFiscal::class, 'servico_id', 'id');
    }

    public static function isServicoOwner($userId, $idServico)
    {
        try {
            return DB::table('servicos')
                ->select('servicos.*')
                ->join('users_servicos', 'servicos.id', '=', 'users_servicos.servicos_id')
                ->where('users_servicos.user_id', '=', $userId)
                ->where('servicos.indicador_ativo', '=', 'S')
                ->where('users_servicos.indicador_ativo', '=', 'S')
                ->where('users_servicos.servicos_id', '=', $idServico)
                ->first();
        } catch (\PDOException $e) {
            dd($e);
        }
    }

    public static function disableUserServicoRelation($userId, $servicoId)
    {
        try {
            DB::table('users_servicos')
                ->where('users_servicos.user_id', '=', $userId)
                ->where('users_servicos.servicos_id', '=', $servicoId)
                ->update(['indicador_ativo' => 'N']);
        } catch (\PDOException $e) {
            dd($e);
        }
    }

    public static function getServicosDoTomador($clienteID, $tomadorID)
    {
        return Servicos::select('servicos.*', 'clientes.razao_social as razao_social', 'users.id as userID', 'tomadores.nome as nome_tomador')
            ->join('users_tomadores_servicos', 'users_tomadores_servicos.servicos_id', '=', 'servicos.id')
            ->join('tomadores', 'tomadores.id', '=', 'users_tomadores_servicos.tomadores_id')
            ->join('users', 'users.id', '=', 'users_tomadores_servicos.user_id')
            ->leftJoin('clientes', 'clientes.id', '=', 'users.cliente_id')
            ->where('clientes.id', '=', $clienteID)
            ->where('tomadores.id', '=', $tomadorID)
            ->where('users_tomadores_servicos.indicador_ativo', '=', 'S')
            ->where('tomadores.indicador_exclusao', '!=', 'S')
            ->where('users.indicador_ativo', '=', 'S')->get();
    }
}
