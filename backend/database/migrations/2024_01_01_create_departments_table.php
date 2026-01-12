<?php

// database/migrations/2024_01_01_create_departments_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
};


// database/migrations/2024_01_02_add_department_to_users_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_admin')->default(false);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn(['department_id', 'is_admin']);
        });
    }
};


// database/migrations/2024_01_03_create_tickets_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['aberto', 'em_andamento', 'aguardando', 'resolvido', 'fechado'])
                  ->default('aberto');
            $table->enum('priority', ['baixa', 'media', 'alta', 'urgente'])
                  ->default('media');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();

            // Índices para melhorar performance
            $table->index(['department_id', 'status']);
            $table->index(['user_id', 'created_at']);
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};


// database/migrations/2024_01_04_create_ticket_comments_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('ticket_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('comment');
            $table->boolean('is_internal')->default(false);
            $table->timestamps();

            $table->index(['ticket_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_comments');
    }
};


// database/migrations/2024_01_05_create_ticket_attachments_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('ticket_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $table->string('filename');
            $table->string('filepath');
            $table->integer('filesize');
            $table->string('mime_type');
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index('ticket_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_attachments');
    }
};


// database/seeders/DepartmentSeeder.php
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