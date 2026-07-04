<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the RBAC roles, permissions and their default mapping.
     *
     * Idempotent: safe to run repeatedly.
     */
    public function run(): void
    {
        // Roles -----------------------------------------------------------
        $roles = [
            'admin' => 'Administrator',
            'manajer' => 'Manajer',
            'staf' => 'Staf',
        ];

        foreach ($roles as $name => $label) {
            Role::updateOrCreate(['name' => $name], ['label' => $label]);
        }

        // Permissions -----------------------------------------------------
        $permissions = [
            'users.view' => 'Lihat Pengguna',
            'users.create' => 'Buat Pengguna',
            'users.update' => 'Ubah Pengguna',
            'users.delete' => 'Hapus Pengguna',
            'settings.manage' => 'Kelola Pengaturan',
            'activity.view' => 'Lihat Aktivitas',
            'media.manage' => 'Kelola Media',
        ];

        foreach ($permissions as $name => $label) {
            Permission::updateOrCreate(['name' => $name], ['label' => $label]);
        }

        // Role → permission mapping --------------------------------------
        $admin = Role::firstWhere('name', 'admin');
        $manajer = Role::firstWhere('name', 'manajer');
        $staf = Role::firstWhere('name', 'staf');

        // Admin gets every permission.
        $admin->givePermissionTo(...array_keys($permissions));

        // Manajer: view/create/update + settings + activity.
        $manajer->givePermissionTo(
            'users.view',
            'users.create',
            'users.update',
            'settings.manage',
            'activity.view',
        );

        // Staf: read-only user access.
        $staf->givePermissionTo('users.view');

        // Assign the admin role to the demo user when present. --------------
        $demo = User::firstWhere('email', 'demo@kit.test');

        $demo?->assignRole('admin');
    }
}
