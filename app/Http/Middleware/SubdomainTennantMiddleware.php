<?php

namespace App\Http\Middleware;

use App\Models\EcommerceSite;
use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SubdomainTennantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestUri = parse_url($request->getUri());
        $site = $this->parseDomainToSite($requestUri);

        if ($site instanceof Tenant) {
            $this->updateDatabaseConnection($site);
        }

        return $next($request);
    }

    /**
     * Parses the domain from a given request URL and retrieves the corresponding Ecommerce Site
     *
     * @param string $requestUrl The URL from which to extract the domain
     * @return Tenant|false Returns the Ecommerce Site object if found, or false if not found
     */
    private function parseDomainToSite($requestUrl) {
        $subDomain = str_replace(
            env("APP_DOMAIN"),
            '',
            $requestUrl
        );

        $subDomain = str_replace('.', '', $subDomain);

        $tenant = Tenant::where('subdomain', $subDomain['host'])->first();

        if ($tenant instanceof Tenant) return $tenant;

        return false;
    }

    /**
     * Each Ecommerce site has its own database connection, we need to change the SCHEMA DB for tenants to the
     * right database
     *
     * @param EcommerceSite $ecommerceSite
     * @return void
     */
    private function updateDatabaseConnection(Tenant $tenant) {
        Session::put('tenant', $tenant);
        Config::set('database.connections.tenant_db.database', $tenant->database_name);
        DB::purge('tenant_db');
        DB::reconnect('tenant_db');
    }
}
