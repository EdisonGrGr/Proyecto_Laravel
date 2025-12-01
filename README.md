# Sistema de Agendamiento de Citas Oftalmológicas

> **Proyecto Final - Laravel - Php**  
> Universidad de Caldas - Ingeniería de Sistemas  
> Diciembre 2025

## Descripción del Proyecto

Aplicación web desarrollada en Laravel 12 con Vue 3 para la gestión de citas médicas en el área de oftalmología. El sistema permite a pacientes agendar citas de manera autónoma mientras que el panel administrativo puede gestionar médicos, horarios y aprobar/rechazar citas.

### Funcionalidades Principales

**Portal Público (Pacientes):**
- Visualización de médicos disponibles con sus especialidades
- Calendario interactivo que muestra disponibilidad en tiempo real
- Formulario de agendamiento de citas
- Notificaciones automáticas por correo electrónico

**Panel Administrativo:**
- Dashboard con estadísticas de citas (pendientes, confirmadas, rechazadas)
- CRUD completo de médicos con gestión de horarios semanales
- Gestión de citas con opciones de aceptar/rechazar/completar
- Vista de calendario semanal con filtros
- Sistema de notificaciones por email a pacientes

### Tecnologías Utilizadas

| Tecnología | Versión | Propósito |
|------------|---------|-----------|
| Laravel | 12.x | Framework PHP backend |
| Laravel Jetstream | 5.x | Sistema de autenticación |
| Inertia.js | 1.x | Adaptador SPA sin API REST |
| Vue.js | 3.x | Framework JavaScript frontend |
| TailwindCSS | 3.x | Framework CSS utility-first |
| PostgreSQL | 14+ | Base de datos relacional |
| Vite | 5.x | Build tool y bundler |
| Mailtrap | - | Servicio de email testing |

## Instalación y Configuración

### Prerrequisitos

Antes de comenzar, asegúrate de tener instalado:
- PHP >= 8.2
- Composer (gestor de dependencias PHP)
- Node.js >= 18 y npm
- PostgreSQL >= 14
- Git

### Pasos de Instalación

**1. Clonar el repositorio**
```bash
git clone https://github.com/EdisonGrGr/Proyecto_Laravel.git
cd Proyecto_Laravel
```

**2. Instalar dependencias de backend**
```bash
composer install
```

**3. Instalar dependencias de frontend**
```bash
npm install
```

**4. Configurar variables de entorno**
```bash
# Copiar archivo de ejemplo
cp .env.example .env

# Generar key de aplicación
php artisan key:generate
```

**5. Configurar base de datos**

Editar el archivo `.env` con tus credenciales de PostgreSQL:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=Proyecto_laravel
DB_USERNAME=postgres
DB_PASSWORD=tu_password
```

**6. Crear la base de datos**
```sql
-- En psql o pgAdmin
CREATE DATABASE "Proyecto_laravel";
```

**7. Ejecutar migraciones y seeders**
```bash
php artisan migrate:fresh --seed
```

Este comando creará:
- 1 usuario administrador
- 3 médicos con horarios configurados
- 4 citas de ejemplo

**8. Compilar assets frontend**
```bash
# Para desarrollo
npm run dev

# Para producción
npm run build
```

**9. Iniciar servidor de desarrollo**
```bash
php artisan serve
```

La aplicación estará disponible en: `http://127.0.0.1:8000`

## Credenciales de Acceso

### Panel Administrativo
- **URL:** http://127.0.0.1:8000/login
- **Email:** admin@oftalmo.ucaldas.edu.co
- **Contraseña:** password

## 📧 Configuración de Emails

El sistema utiliza Mailtrap para testing de emails. Configurar en `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_mailtrap_username
MAIL_PASSWORD=tu_mailtrap_password
```

Para obtener credenciales gratuitas: https://mailtrap.io

##  Estructura del Proyecto

```
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Controladores del panel admin
│   │   └── PublicController.php
│   ├── Models/
│   │   ├── Doctor.php      # Modelo de médicos
│   │   ├── Appointment.php # Modelo de citas
│   │   └── User.php
│   └── Mail/               # Mailables para notificaciones
├── database/
│   ├── migrations/         # Esquema de base de datos
│   ├── seeders/           # Datos de prueba
│   └── factories/         # Factories para testing
├── resources/
│   ├── js/
│   │   ├── Pages/
│   │   │   ├── Public/    # Vistas públicas (Vue)
│   │   │   └── Admin/     # Vistas admin (Vue)
│   │   └── Layouts/
│   └── views/             # Templates Blade
├── routes/
│   └── web.php           # Definición de rutas
└── public/               # Assets compilados
```

## 🎯 Funcionalidades Implementadas

### Base de Datos
- ✅ Migraciones para tablas: users, doctors, appointments
- ✅ Relaciones: Doctor hasMany Appointments
- ✅ Seeders con datos de prueba
- ✅ Factories para generación de datos

### Backend (Laravel)
- ✅ Sistema de autenticación con Jetstream
- ✅ CRUD completo de médicos
- ✅ Gestión de citas con estados (pending, confirmed, rejected, completed)
- ✅ Validación de disponibilidad de horarios
- ✅ Detección de colisiones de citas
- ✅ Sistema de notificaciones por email
- ✅ Route model binding con slugs

### Frontend (Vue + Inertia)
- ✅ SPA (Single Page Application) sin recarga de página
- ✅ Interfaz responsive con TailwindCSS
- ✅ Calendario interactivo para selección de citas
- ✅ Dashboard administrativo con estadísticas
- ✅ Formularios reactivos con validación
- ✅ Componentes reutilizables

## 🧪 Testing

Para ejecutar las pruebas (si se implementan):
```bash
php artisan test
```

## 🐛 Solución de Problemas

**Error: Class DatabaseSeeder does not exist**
```bash
composer dump-autoload
php artisan optimize:clear
```

**Error: SQLSTATE[42P01] Table doesn't exist**
```bash
php artisan migrate:fresh --seed
```

**Frontend no se actualiza**
```bash
npm run build
# O en desarrollo:
npm run dev
```

## Notas del Desarrollador

- Las citas tienen una duración configurable (por defecto 20 minutos) en `.env`
- Los horarios de médicos se almacenan en formato JSON para mayor flexibilidad
- Se implementó un sistema de slugs para URLs amigables
- Los emails tienen fallback con try-catch para evitar crashes

## Autores

**Jhon Edison Garcia - Jose Daniel Arias**  
Universidad de Caldas - Ingeniería de Sistemas  
Contacto: admin@oftalmo.ucaldas.edu.co

## 📄 Licencia

Este proyecto fue desarrollado con fines académicos.  
Laravel framework: [MIT license](https://opensource.org/licenses/MIT)
