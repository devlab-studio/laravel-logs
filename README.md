<br></br>
<p align="center">
  <a href="https://dev-lab.es">
    <img src="https://dev-lab.es/assets/logos/main-light.svg" alt="Devlab Logo" width="400"/>
  </a>
</p>
<br></br>


**Laravel Logs** es un paquete Laravel para la gestión avanzada de logs y auditorías, permitiendo registrar, consultar y limpiar logs de manera eficiente en tus proyectos Laravel.

- Registro y consulta de logs personalizados
- Auditoría de modelos y procedimientos
- Comandos para limpiar y gestionar logs
- Configuración flexible y extensible

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

Consulta logs desde consola:

```bash
php artisan logs:list
```


## Seeders

Si necesitas datos de ejemplo para pruebas, puedes crear tus propios seeders para poblar la tabla de logs.


## Recursos

- [Soporte y contacto](https://dev-lab.es/contact)

---

<div align="center">
  © 2026 <a href="https://dev-lab.es">Devlab Studio</a>
</div>
