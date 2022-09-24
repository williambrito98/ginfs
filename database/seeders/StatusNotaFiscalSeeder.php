<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusNotaFiscalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_nota_fiscal')->insert([
            'codStatus' => '1',
            'nomeStatus' => 'Emitida',
        ]);

        DB::table('status_nota_fiscal')->insert([
            'codStatus' => '2',
            'nomeStatus' => 'Em análise',
        ]);

        DB::table('status_nota_fiscal')->insert([
            'codStatus' => '3',
            'nomeStatus' => 'Cancelada',
        ]);

        DB::table('status_nota_fiscal')->insert([
            'codStatus' => '4',
            'nomeStatus' => 'Erro',
        ]);
    }
}
