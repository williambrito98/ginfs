<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Roles;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p1 = Roles::firstOrCreate([
            'nome' => 'Admin',
            'descricao' => 'acesso total ao sistema'
        ]);

        $p2 = Roles::firstOrCreate([
            'nome' => 'cliente',
            'descricao' => 'acesso ao sistema como cliente'
        ]);
        
    }
}
