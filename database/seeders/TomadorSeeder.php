<?php

namespace Database\Seeders;

use App\Models\Tomadores;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TomadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tomador1 = Tomadores::firstOrCreate([
            "cpf_cnpj" => "12345678910",
            "nome" => "JOAO DAS COUVES",
            "inscricao_municipal" => "12343462",
            "tipo_emissaos_id" => "1"
        ]);
    }
}
