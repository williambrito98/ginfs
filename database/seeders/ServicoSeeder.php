<?php

namespace Database\Seeders;

use App\Models\Servicos;
use Illuminate\Database\Seeder;

class ServicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Servicos::firstOrCreate([
            "codigo" => "12345",
            "nome" => "teste12345",
            "retencao_iss" => true,
            "indicador_ativo" => "S"
        ]);

        Servicos::firstOrCreate([
            "codigo" => "78909",
            "nome" => "teste7890",
            "retencao_iss" => false,
            "indicador_ativo" => "S"
        ]);

        Servicos::firstOrCreate([
            "codigo" => "283974",
            "nome" => "teste1208838",
            "retencao_iss" => false,
            "indicador_ativo" => "N"
        ]);
    }
}
