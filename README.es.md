<br></br>
<p align="center">
  <a href="https://dev-lab.es">
    <img src="https://dev-lab.es/assets/logos/main-light.svg" alt="Devlab Logo" width="400"/>
  </a>
</p>
<br></br>

<p align="right"> <a href="README.md"><img src="https://img.shields.io/badge/English-View%20in%20EN-blue.svg?style=flat-square" alt="English"/></a> </p>

**Laravel Logs** es un paquete Laravel para la gestión avanzada de logs y auditorías, permitiendo registrar, consultar y limpiar logs de manera eficiente en tus proyectos Laravel.

- Registro y consulta de logs personalizados
- Auditoría de modelos y procedimientos
- Comandos para limpiar y gestionar logs
- Configuración flexible y extensible

## Qué hace

Este paquete añade una capa ligera de auditoría para modelos Eloquent, registrando operaciones de guardado y borrado.

- Traza procedimientos como `App\\Models\\Order::save` y `App\\Models\\Order::delete`
- Guarda el detalle de cambios en formato JSON
- Registra el usuario responsable de la acción
- Mantiene una tabla normalizada de procedimientos para facilitar filtros y reportes

## Instalación

Instala el paquete vía composer:

```bash
composer require devlab-studio/laravel-logs
```

Publica y ejecuta las migraciones:

```bash
php artisan vendor:publish --tag=laravel-logs-migrations
php artisan migrate
```

Publica el archivo de configuración:

```bash
php artisan vendor:publish --tag=laravel-logs-config
```

## Comandos útiles

Limpia los logs antiguos:

```bash
php artisan logs:clear
```

`logs:clear` elimina registros con más de 12 meses de antigüedad.

## Cómo funciona

1. Tu modelo extiende el modelo base del paquete (`Devlab\\LaravelLogs\\Models\\Model`).
2. En `save()`, el paquete detecta atributos modificados y registra originales vs cambios.
3. En `delete()`, el paquete registra el ID del modelo eliminado.
4. El procedimiento se registra en `models_procedures` si todavía no existe.
5. La acción se guarda en `models_logs` con timestamps y `created_user`.

## Estructura de base de datos

### `models_procedures`

- `id`
- `procedure` (ejemplo: `App\\Models\\Invoice::save`)
- `created_at`, `updated_at`

### `models_logs`

- `id`
- `procedure`
- `procedure_id` (FK a `models_procedures.id`)
- `data` (JSON / text)
- `created_user`
- `created_at`, `updated_at`

## Ejemplo de uso

Extiende tus modelos desde el modelo base del paquete:

```php
<?php

namespace App\Models;

use Devlab\LaravelLogs\Models\Model;

class Customer extends Model
{
  protected $fillable = ['name', 'email'];
}
```

Crea y actualiza registros como siempre:

```php
$customer = Customer::create([
  'name' => 'Jane Doe',
  'email' => 'jane@example.com',
]);

$customer->email = 'jane.doe@example.com';
$customer->save();
```

Cada operación genera una entrada de auditoría en `models_logs`.

## Consulta de logs

Puedes consultar logs directamente con Eloquent:

```php
use Devlab\LaravelLogs\Models\ModelsLog;

$latestLogs = ModelsLog::query()
  ->latest('id')
  ->limit(20)
  ->get();
```

El paquete también incluye helpers en `ModelsLog` (como `dlGet`) para obtener resultados filtrados.

## Seeders

Si necesitas datos de ejemplo para pruebas, puedes crear tus propios seeders para poblar la tabla de logs.

## Notas

- El paquete usa el usuario autenticado para `created_user` cuando existe sesión.
- Si no hay usuario autenticado, usa `config('constants.users.system')` como fallback.
- Conviene definir ese valor en tu configuración para entornos CLI o procesos en background.

## Recursos

- [Soporte y contacto](https://dev-lab.es/contact)

---

<div align="center">
  © 2026 <a href="https://dev-lab.es">Devlab Studio</a>
</div>
