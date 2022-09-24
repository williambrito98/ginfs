<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Mockery\Expectation;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = $this->createIfNotExists('name', 'Administrador', 'adm@uphold', 'adm@uphold');

        try {
            $user->createRole('Admin');
        } catch (Expectation $th) {}
    }

    public function createIfNotExists($key, $value, $password, $email) {
        $record = User::where($key, $value)->first();

        if (!$record) {
            $record = User::firstOrCreate([
                'name' => $value,
                'email' => $email,
                'password' => Hash::make($password),
                'indicador_ativo' => 'S'
            ]);
        }

        return $record;

    }
}
