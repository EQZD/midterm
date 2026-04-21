<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {

        $superAdmin = Role::firstOrCreate(
            ['name' => Role::SUPER_ADMIN],
            [
                'display_name' => 'Super Admin',
                'description'  => 'Full system access: manage users, roles, members, and settings.',
            ]
        );

        $manager = Role::firstOrCreate(
            ['name' => Role::MANAGER],
            [
                'display_name' => 'Manager',
                'description'  => 'Manage members, edit membership types, and view all reports.',
            ]
        );

        $staff = Role::firstOrCreate(
            ['name' => Role::STAFF],
            [
                'display_name' => 'Staff',
                'description'  => 'Register new members and view member profiles.',
            ]
        );

        $member = Role::firstOrCreate(
            ['name' => Role::MEMBER],
            [
                'display_name' => 'Member',
                'description'  => 'View and update own membership profile only.',
            ]
        );

        $adminUser = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password')]
        );
        $adminUser->assignRole($superAdmin);

        $managerUser = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            ['name' => 'Club Manager', 'password' => Hash::make('password')]
        );
        $managerUser->assignRole($manager);

        $staffUser = User::firstOrCreate(
            ['email' => 'staff@example.com'],
            ['name' => 'Front Desk Staff', 'password' => Hash::make('password')]
        );
        $staffUser->assignRole($staff);

        $memberUser = User::firstOrCreate(
            ['email' => 'member@example.com'],
            ['name' => 'John Member', 'password' => Hash::make('password')]
        );
        $memberUser->assignRole($member);
    }
}
