<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Kyslik\ColumnSortable\Sortable;

use App\Library\AppHelper;

class Tomadores extends Model
{
    use HasFactory;

    use Sortable;

    protected $table = 'tomadores';

    protected $fillable = ['cpf_cnpj', 'nome', 'inscricao_municipal', 'tipo_emissaos_id'];

    public $sortable = ['nome', 'created_at', 'tipo_emissaos_id'];

    protected static function boot()
    {
        parent::boot();

        Tomadores::saving(function ($model) {
            if (isset($model->cpf_cnpj)) {
                $model->cpf_cnpj = AppHelper::limpaCPF_CNPJ($model->cpf_cnpj);
            }
        });

        Tomadores::retrieved(function ($model) {
            if (isset($model->cpf_cnpj)) {
                $model->cpf_cnpj = AppHelper::formatarCPF_CNPJ($model->cpf_cnpj);
            }
        });
    }

    public function notaFiscal()
    {
        return $this->hasMany(NotaFiscal::class, 'users_tomadores');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_tomadores');
    }

    public function tipoEmissao()
    {
        return $this->hasOne(TipoEmissao::class, 'id', 'tipo_emissaos_id');
    }

    public static function isTomadorOwner($userId, $tomadorId)
    {
        try {
            return DB::table('tomadores')
                ->select('tomadores.*', 'tipo_emissaos.nome as nome_emissao')
                ->join('users_tomadores', 'tomadores.id', '=', 'users_tomadores.tomadores_id')
                ->join('tipo_emissaos', 'tipo_emissaos.id', '=', 'tomadores.tipo_emissaos_id')
                ->where('users_tomadores.user_id', '=', $userId)
                ->where('users_tomadores.tomadores_id', '=', $tomadorId)
                ->first();
        } catch (\PDOException $e) {
            throw new $e->getMessage();
        }
    }

    public static function disableUserTomadorRelation($userId, $tomadorId)
    {
        try {
            DB::table('users_tomadores')
                ->where('users_tomadores.user_id', '=', $userId)
                ->where('users_tomadores.tomadores_id', '=', $tomadorId)
                ->update(['users_tomadores.indicador_ativo' => 'N']);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
}
