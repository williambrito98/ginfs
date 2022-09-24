<?php

namespace Database\Seeders;

use App\Models\TipoEmissao;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class TipoEmissaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->createIfNotExists('nome', 'Normal', 'Dia limite de correcao ate dia 30 do mes corrente');
        $this->createIfNotExists('nome', 'Seguradora', 'Dia limite de correcao ate dia 5 do mes seguinte');

    }

    public function createIfNotExists($key, $value, $description) {
        $record = TipoEmissao::where($key, $value)->first();

        if (!$record) {
            TipoEmissao::firstOrCreate([
                'nome' => $value,
                'descricao' => $description,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

    }
}
