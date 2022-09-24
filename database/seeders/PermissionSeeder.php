<?php

namespace Database\Seeders;

use App\Models\Clientes;
use Illuminate\Database\Seeder;
use App\Models\Permissions;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $viewUser = Permissions::firstOrCreate([
            'nome' => 'ver-usuarios',
            'descricao' => 'Acesso a lista de usuarios'
        ]);

        $createUser = Permissions::firstOrCreate([
            'nome' => 'adicionar-usuarios',
            'descricao' => 'Adicionar usuarios'
        ]);

        $deleteUser = Permissions::firstOrCreate([
            'nome' => 'deletar-usuarios',
            'descricao' => 'Deletar usuarios'
        ]);

        $editUser = Permissions::firstOrCreate([
            'nome' => 'editar-usuarios',
            'descricao' => 'Deletar usuarios'
        ]);

        $viewRelationsWithTomadores = Permissions::firstOrCreate([
            'nome' => 'ver-relacoes-com-tomadores',
            'descricao' => 'Ver as os tomadores dos cliente'
        ]);

        $rolesView = Permissions::firstOrCreate([
            'nome' => 'ver-permissoes',
            'descricao' => 'Ver as permissões do sistema'
        ]);

        $addRoles = Permissions::firstOrCreate([
            'nome' => 'adicionar-permissoes',
            'descricao' => 'Adicionar permissões no sistema'
        ]);

        $editRoles = Permissions::firstOrCreate([
            'nome' => 'editar-permissoes',
            'descricao' => 'Editar permissões no sistema'
        ]);

        $deleteRoles = Permissions::firstOrCreate([
            'nome' => 'deletar-permissoes',
            'descricao' => 'Deletar permissões no sistema'
        ]);

        $viewTomadores = Permissions::firstOrCreate([
            'nome' => 'ver-tomadores',
            'descricao' => 'Ver os tomadores'
        ]);

        $addTomadores = Permissions::firstOrCreate([
            'nome' => 'adicionar-tomadores',
            'descricao' => 'Adicionar tomadores'
        ]);

        $editTomadores = Permissions::firstOrCreate([
            'nome' => 'editar-tomadores',
            'descricao' => 'Editar os tomadores'
        ]);

        $deleteTomadores = Permissions::firstOrCreate([
            'nome' => 'deletar-tomadores',
            'descricao' => 'Deletar tomadores'
        ]);

        $createRelationTomadoresWithUsers = Permissions::firstOrCreate([
            'nome' => 'relacionar-tomadores-aos-clientes',
            'descricao' => 'Relacionar Tomadores com os Clientes'
        ]);

        $deleteRelationTomadoresWithUsers = Permissions::firstOrCreate([
            'nome' => 'deletar-relacionamento-tomadores-com-clientes',
            'descricao' => 'Relacionar Tomadores com os Clientes'
        ]);

        $viewServicos = Permissions::firstOrCreate([
            'nome' => 'ver-servicos',
            'descricao' => 'Ver apenas os servicos'
        ]);

        $addServicos = Permissions::firstOrCreate([
            'nome' => 'adicionar-servicos',
            'descricao' => 'Adicionar serviços'
        ]);

        $editServicos = Permissions::firstOrCreate([
            'nome' => 'editar-servicos',
            'descricao' => 'Editar os serviços'
        ]);

        $deleteServicos = Permissions::firstOrCreate([
            'nome' => 'deletar-servicos',
            'descricao' => 'Deletar os serviços'
        ]);

        $viewFormulas = Permissions::firstOrCreate([
            'nome' => 'ver-formulas',
            'descricao' => 'Ver as formulas'
        ]);

        $addFormulas = Permissions::firstOrCreate([
            'nome' => 'adicionar-formulas',
            'descricao' => 'Adicionar formulas'
        ]);

        $editFormulas = Permissions::firstOrCreate([
            'nome' => 'editar-formulas',
            'descricao' => 'Editar as  formulas'
        ]);

        $deleteFormulas = Permissions::firstOrCreate([
            'nome' => 'deletar-formulas',
            'descricao' => 'Deletar as formulas'
        ]);

        $deleteFormulas = Permissions::firstOrCreate([
            'nome' => 'ver-faturamento',
            'descricao' => 'Ver faturamentos de clientes'
        ]);

        $deleteFormulas = Permissions::firstOrCreate([
            'nome' => 'salvar-faturamento',
            'descricao' => 'Salvar e editar faturamentos de clientes'
        ]);
        $viewClintes = Permissions::firstOrCreate([
            'nome' => 'ver-clientes',
            'descricao' => 'Ver todos os clientes cadastrados'
        ]);

        $editClientes = Permissions::firstOrCreate([
            'nome' => 'editar-clientes',
            'descricao' => 'Editar o cadastro dos clientes'
        ]);

        $AddClientes = Permissions::firstOrCreate([
            'nome' => 'adicionar-clientes',
            'descricao' => 'Adicionar novos clientes'
        ]);

        $deleteClientes = Permissions::firstOrCreate([
            'nome' => 'deletar-clientes',
            'descricao' => 'Deletar clientes'
        ]);

        $viewRelationTomadorServico = Permissions::firstOrCreate([
            'nome' => 'ver-relacoes-com-tomadores-e-seus-servicos',
            'descricao' => 'Ver as os servicos cadastrados para os tomadores'
        ]);

        $relaTomadorServico = Permissions::firstOrCreate([
            'nome' => 'relacionar-tomadores-aos-servicos',
            'descricao' => 'Relacionar tomador com os tipos de serviços'
        ]);

        $deleterelationTomadorServico = Permissions::firstOrCreate([
            'nome' => 'deletar-relacionamento-tomadores-com-servicos',
            'descricao' => 'Deletar o relacionamento de tomadores com servicos'
        ]);

        $addRoles = Permissions::firstOrCreate([
            'nome' => 'adicionar-cargos',
            'descricao' => 'Adicionar cargos'
        ]);

        $editRoles = Permissions::firstOrCreate([
            'nome' => 'editar-cargos',
            'descricao' => 'Editar cargos'
        ]);

        $removeRoles = Permissions::firstOrCreate([
            'nome' => 'deletar-cargos',
            'descricao' => 'Deletar cargos'
        ]);

        $viewRoles = Permissions::firstOrCreate([
            'nome' => 'ver-cargos',
            'descricao' => 'Ver todos os cargos'
        ]);

        $viewCidades = Permissions::firstOrCreate([
            'nome' => 'ver-cidades',
            'descricao' => 'Ver todas as cidades'
        ]);

        $removeCidades = Permissions::firstOrCreate([
            'nome' => 'deletar-cidades',
            'descricao' => 'Deletar cidades'
        ]);

        $addCidades = Permissions::firstOrCreate([
            'nome' => 'adicionar-cidades',
            'descricao' => 'Adicionar cidades'
        ]);

        $editCidades = Permissions::firstOrCreate([
            'nome' => 'editar-cidades',
            'descricao' => 'Editar cidades'
        ]);

    }
}
