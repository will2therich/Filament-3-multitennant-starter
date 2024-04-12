<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Doctrine\DBAL\Connection;
use Illuminate\Console\Command;
use Doctrine\DBAL\Schema\Comparator;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class MigrateCommand extends Command
{
    use ConfirmableTrait;

    protected $signature = 'weblabs:migrate-tenants {--site=} {--f|--fresh} {--s|--seed} {--force}';

    public function handle()
    {
        if (!$this->confirmToProceed()) {
            return 1;
        }

        if (!empty($this->option('site'))) {
            $tenantDbs = Tenant::where('id', $this->option('site'))->get();
        } else {
            $tenantDbs = Tenant::all();
        }


        if (!is_null($tenantDbs)) {
            $this->info('Migrating Tenant DBs');
            foreach ($tenantDbs as $tenantDb) {
                $this->line('');
                $this->info('Migrating: ' . $tenantDb->name);
                $this->changeTennantDb($tenantDb);
                $this->info('Running Migrations');
                $this->call('migrate');
            }
        }

        if ($this->option('seed')) {
            $this->call('db:seed', ['--force' => true]);
        }

        return 0;
    }
    private function changeTennantDb(Tenant $tenant) {
        Config::set('database.connections.tenant_db.database', $tenant->database_name);
        DB::purge('tenant_db');
        DB::reconnect('tenant_db');
    }
}

