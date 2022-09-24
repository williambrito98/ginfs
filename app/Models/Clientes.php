<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Library\AppHelper;
use Kyslik\ColumnSortable\Sortable;

class Clientes extends Model
{
    use HasFactory;

    use Sortable;

    protected $table = 'clientes';

    public $sortable = ['razao_social'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'cpf_cnpj',
        'inscricao_municipal',
        'faturamento_total',
        'razao_social',
        'cidade',
        'tipo_emissaos_id'
    ];

    protected static function boot()
    {
        parent::boot();

        Clientes::retrieved(function ($model) {
            if (isset($model->cpf_cnpj)) {
                $model->cpf_cnpj = AppHelper::formatarCPF_CNPJ($model->cpf_cnpj);
            }
        });
    }

    public function NotasFiscais()
    {
        return $this->hasMany(NotaFiscal::class, 'cliente_id', 'id');
    }

    public function FaturamentoClientes()
    {
        return $this->hasMany(FaturamentoClientes::class, 'id', 'clientes_id');
    }

    public function tipoEmissao()
    {
        return $this->hasOne(TipoEmissao::class, 'id', 'tipo_emissaos_id');
    }



    public function Cidade()
    {

        return $this->hasOne(Cidades::class, 'id', 'cidade_id');
    }
}
