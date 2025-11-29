# Sistema de Agendamiento de Citas - Oftalmología

Sistema web para la gestión de citas médicas de oftalmología construido con Laravel 12 y Vue 3.

## Características

- **Portal Público**: Los pacientes pueden ver médicos disponibles y agendar citas
- **Panel Administrativo**: Gestión completa de citas, médicos y horarios
- **Notificaciones por Email**: Confirmaciones automáticas vía Mailtrap
- **Calendario Interactivo**: Visualización de disponibilidad semanal
- **Estados de Citas**: Pendiente, Confirmada, Rechazada, Completada

## Tecnologías

- Laravel 12.x
- Laravel Jetstream (Inertia + Vue)
- Vue 3 + Inertia.js
- TailwindCSS
- PostgreSQL
- Vite

## Requisitos

- PHP >= 8.2
- Composer
- Node.js >= 18
- PostgreSQL >= 14

## Instalación

1. Clonar el repositorio
```bash
git clone [tu-repositorio]
cd oftalmo-agendamiento
```

2. Instalar dependencias de PHP
```bash
composer install
```

3. Instalar dependencias de Node.js
```bash
npm install
```

4. Configurar el archivo `.env`
```bash
cp .env.example .env
php artisan key:generate
```

5. Configurar la base de datos en `.env`
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=Proyecto_laravel
DB_USERNAME=postgres
DB_PASSWORD=1234
```

6. Ejecutar migraciones y seeders
```bash
php artisan migrate:fresh
```

7. Poblar la base de datos (usar tinker)
```bash
php artisan tinker
```
Luego ejecutar el código del seeder manualmente.

8. Compilar assets
```bash
npm run build
```

9. Iniciar el servidor
```bash
php artisan serve
```

## Uso

### Acceso Público
- URL: `http://127.0.0.1:8000`
- Funciones: Ver médicos, agendar citas

### Panel Administrativo
- URL: `http://127.0.0.1:8000/login`
- Usuario: `admin@oftalmo.test`
- Contraseña: `password`
- Funciones: Gestión de citas, médicos, calendario

## Configuración de Emails

El sistema usa Mailtrap para desarrollo. Configurar en `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_username
MAIL_PASSWORD=tu_password
```

## Estructura del Proyecto

- `app/Models/` - Modelos (Doctor, Appointment, User)
- `app/Http/Controllers/` - Controladores (Public, Admin)
- `app/Mail/` - Mailables para notificaciones
- `resources/js/Pages/` - Componentes Vue (Public, Admin)
- `database/migrations/` - Migraciones de base de datos
- `database/seeders/` - Seeders para datos iniciales

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
