<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $roles = [
            [
                'name' => 'super_admin',
                'label' => 'Super Administrateur',
                'description' => 'Dispose d\'un accès complet à la plateforme. Gère les paramètres du système, les utilisateurs, les rôles, les permissions ainsi que l\'ensemble des fonctionnalités métier.',
            ],
            [
                'name' => 'administrator',
                'label' => 'Administrateur',
                'description' => 'Gère l\'exploitation agricole, supervise les sites, les campagnes, les utilisateurs et l\'ensemble des opérations métier.',
            ],
            [
                'name' => 'site_manager',
                'label' => 'Responsable de site',
                'description' => 'Organise les activités d\'un ou plusieurs sites agricoles. Gère les ouvriers, les tâches, les interventions, les récoltes, les stocks du site et le suivi des opérations quotidiennes.',
            ],
            [
                'name' => 'sales_agent',
                'label' => 'Commercial',
                'description' => 'Gère les clients, les ventes, les livraisons et le suivi commercial de l\'exploitation.',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                [
                    'label' => $role['label'],
                    'description' => $role['description'],
                ]
            );
        }
    }
}
