<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Chama o seeder de departamentos que você já criou
        $this->call([
            DepartmentSeeder::class,
        ]);

        // 2. Cria um USUÁRIO DE TESTE para você conseguir logar
        // Como você não tem o AD em casa, vamos usar esse usuário
        User::create([
            'name' => 'Douglas Teste',
            'email' => 'douglas@empresa.com',
            'password' => Hash::make('123456'), // Senha para teste
            'department_id' => 1, // Vincula ao departamento de TI (ID 1)
            'is_admin' => true,
        ]);
    }
}