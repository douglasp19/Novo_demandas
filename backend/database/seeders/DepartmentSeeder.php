<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            [
                'name' => 'TI - Tecnologia da Informação',
                'description' => 'Suporte técnico e infraestrutura',
                'email' => 'ti@empresa.com',
                'is_active' => true,
            ],
            [
                'name' => 'RH - Recursos Humanos',
                'description' => 'Gestão de pessoas e benefícios',
                'email' => 'rh@empresa.com',
                'is_active' => true,
            ],
            [
                'name' => 'Financeiro',
                'description' => 'Gestão financeira e contábil',
                'email' => 'financeiro@empresa.com',
                'is_active' => true,
            ],
            [
                'name' => 'Facilities',
                'description' => 'Manutenção e infraestrutura predial',
                'email' => 'facilities@empresa.com',
                'is_active' => true,
            ],
            [
                'name' => 'Compras',
                'description' => 'Aquisição de materiais e serviços',
                'email' => 'compras@empresa.com',
                'is_active' => true,
            ],
        ];

        foreach ($departments as $department) {
            DB::table('departments')->insert(array_merge($department, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}