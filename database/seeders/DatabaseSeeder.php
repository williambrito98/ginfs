<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(TipoEmissaoSeeder::class);
        $this->call(TomadorSeeder::class);
        $this->call(ServicoSeeder::class);
        $this->call(StatusNotaFiscalSeeder::class);
    }
}
