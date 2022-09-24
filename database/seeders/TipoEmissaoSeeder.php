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
        TipoEmissao::firstOrCreate([
            'nome' => 'Normal',
            'descricao' => 'Dia limite de correcao ate dia 30 do mes corrente',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        TipoEmissao::firstOrCreate([
            'nome' => 'Seguradora',
            'descricao' => 'Dia limite de correcao ate dia 5 do mes seguinte',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
