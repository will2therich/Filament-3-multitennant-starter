<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'WilliamRich',
            'email' => 'william.rich@weblabs.dev',
            'password' => Hash::make('password'),
            'administrator' => 1
        ]);

        $user->save();

        $tenant = Tenant::factory()->create([
            'name' => 'Default Tenant',
            'owner_id' => $user->id,
            'database_name' => 'kc_tenant_default'
        ]);

        $tenant->save();
    }
}
