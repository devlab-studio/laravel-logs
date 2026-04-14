<br></br>
<p align="center">
  <a href="https://dev-lab.es">
    <img src="https://dev-lab.es/assets/logos/main-light.svg" alt="Devlab Logo" width="400"/>
  </a>
</p>
<br></br>

<p align="right"> <a href="README.es.md"><img src="https://img.shields.io/badge/Espa%C3%B1ol-Ver%20en%20ES-blue.svg?style=flat-square" alt="Español"/></a> </p>

**Laravel Logs** is a Laravel package for advanced logs and audits management, allowing you to register, query, and clean logs efficiently in your Laravel projects.

- Register and query custom logs
- Audit models and procedures
- Commands to clean and manage logs
- Flexible and extensible configuration

## What It Does

This package adds a lightweight audit layer for Eloquent models by logging save and delete operations.

- Tracks procedure names such as `App\\Models\\Order::save` and `App\\Models\\Order::delete`
- Stores change payloads in JSON format
- Records the user responsible for the action
- Keeps a normalized table of procedures for easier filtering/reporting

## Installation

Install the package via Composer:

```bash
composer require devlab-studio/laravel-logs
```

Publish and run the migrations:

```bash
php artisan vendor:publish --tag=laravel-logs-migrations
php artisan migrate
```

Publish the configuration file:

```bash
php artisan vendor:publish --tag=laravel-logs-config
```

## Useful Commands

Clean old logs:

```bash
php artisan logs:clear
```

`logs:clear` removes records older than 12 months.

## How It Works

1. Your model extends the package base model (`Devlab\\LaravelLogs\\Models\\Model`).
2. On `save()`, the package detects dirty attributes and logs original vs changed data.
3. On `delete()`, the package logs the deleted model ID.
4. The procedure name is registered in `models_procedures` if it does not exist yet.
5. The action is stored in `models_logs` with timestamps and `created_user`.

## Database Structure

### `models_procedures`

- `id`
- `procedure` (example: `App\\Models\\Invoice::save`)
- `created_at`, `updated_at`

### `models_logs`

- `id`
- `procedure`
- `procedure_id` (FK to `models_procedures.id`)
- `data` (JSON / text)
- `created_user`
- `created_at`, `updated_at`

## Usage Example

Extend your models from the package base model:

```php
<?php

namespace App\Models;

use Devlab\LaravelLogs\Models\Model;

class Customer extends Model
{
  protected $fillable = ['name', 'email'];
}
```

Create and update records as usual:

```php
$customer = Customer::create([
  'name' => 'Jane Doe',
  'email' => 'jane@example.com',
]);

$customer->email = 'jane.doe@example.com';
$customer->save();
```

Each operation writes an audit entry in `models_logs`.

## Querying Logs

You can query logs directly with Eloquent:

```php
use Devlab\LaravelLogs\Models\ModelsLog;

$latestLogs = ModelsLog::query()
  ->latest('id')
  ->limit(20)
  ->get();
```

The package also includes helper methods in `ModelsLog` (like `dlGet`) for filtered retrieval.

## Seeders

If you need sample data for testing, you can create your own seeders to populate the logs table.

## Notes

- The package expects an authenticated user for `created_user` when available.
- If no authenticated user exists, it falls back to `config('constants.users.system')`.
- Ensure your application defines that fallback config value for CLI/background contexts.

## Resources

- [Support and contact](https://dev-lab.es/contact)

---

<div align="center">
  © 2026 <a href="https://dev-lab.es">Devlab Studio</a>
</div>
