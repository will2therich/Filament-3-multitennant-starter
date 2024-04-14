![Filament V3 Multi-tenant Starter](https://socialify.git.ci/will2therich/Filament-3-multitennant-starter/image?language=1&name=1&owner=1&pattern=Formal%20Invitation&stargazers=1&theme=Light)

# Filament V3 Multi-Tennant Starter Kit

This repository serves as a starter kit for developing multi-tenancy applications with a database-per-tenant architecture using Filament V3 integrated with Laravel 11 and supported by Laravel Octane for high-performance handling of concurrent requests. Each tenant has its own database, ensuring data isolation and security between tenants. This setup includes a comprehensive management interface and custom migration commands tailored for this architecture.

## Features

- **Laravel 11**: Utilize the latest features of Laravel 11 for robust backend development.
- **Laravel Octane**: Enhances the performance of the application using high-powered server handling capabilities, ideal for high concurrency environments.
- **Filament 3**: Integrated Filament 3 admin panel for intuitive management interfaces.
- **Multi-Tenancy**: Core support for a database-per-tenant architecture, which allows distinct and isolated data management for different tenants.
- **Dual Panel System**: 
  - **Admin Panel**: For system-wide management tasks.
  - **App Panel**: For tenant-specific operations.
- **Enhanced User Model**: Includes an `administrator` flag to distinguish between regular users and administrators.
- **Custom Migration Command**: `weblabs:migrate-tenants` facilitates migration specifically tailored to operate across multiple tenant databases. It supports an optional `--site` parameter to specify a tenant ID for targeted operations.


## Getting Started

To get started with this starter kit, clone the repository to your local machine:

```
git clone https://github.com/will2therich/Filament-3-multitennant-starter.git
cd filament-3-multitennant-starter
```

### Prerequisites

Ensure you have the following installed:
- PHP >= 8.3
- Composer
- Node.js and npm (for compiling assets)

### Installation

1. Install PHP dependencies:
   ```
   composer install
   ```

2. Setup your environment file:
   ```
   cp .env.example .env
   ```

3. Generate an app key:
   ```
   php artisan key:generate
   ```

4. Run migrations and seed the database (if applicable):
   ```
   php artisan migrate --seed
   ```

5. Start the development server:
   ```bash
   php artisan serve
   ```

## Usage

To migrate tenant databases, use the custom command:

```bash
php artisan weblabs:migrate-tenants
```

Optional parameter to target a specific tenant:

```bash
php artisan weblabs:migrate-tenants --site={tenant_id}
```

## Contributing

Contributions are welcome! Please read our [contributing guidelines](CONTRIBUTING.md) before submitting pull requests.

## Support

For support please open an issue in this repository.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Acknowledgments

This starter kit is maintained by WebLabs Technologies.
