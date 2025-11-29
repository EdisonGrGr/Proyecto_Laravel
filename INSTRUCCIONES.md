# Sistema de Agendamiento de Citas Médicas - Oftalmología

Plataforma web completa para el agendamiento, aprobación y gestión de citas médicas en el área de oftalmología.

## 🏥 Características Principales

### Vista Pública (Sin autenticación)
- ✅ Consulta de disponibilidad semanal por médico
- ✅ Agendamiento de citas en espacios disponibles
- ✅ Visualización de perfiles de médicos
- ✅ Sistema de calendario interactivo
- ✅ Notificaciones por correo electrónico

### Panel Administrativo (Con autenticación Jetstream)
- ✅ Gestión completa de solicitudes de citas
- ✅ Aceptación/rechazo de citas pendientes
- ✅ Calendario semanal por médico
- ✅ Gestión de médicos y horarios
- ✅ Dashboard con estadísticas
- ✅ Filtros avanzados

## 🛠 Stack Tecnológico

- **Backend**: Laravel 12.x
- **Frontend**: Inertia.js + Vue 3
- **Autenticación**: Laravel Jetstream (Inertia + Vue)
- **Estilos**: TailwindCSS
- **Base de datos**: PostgreSQL
- **Email**: Mailtrap (desarrollo)

## 📋 Requisitos del Sistema

- PHP >= 8.2
- Composer
- Node.js >= 18
- PostgreSQL >= 13
- NPM o Yarn

## 🚀 Instalación

### 1. Clonar el repositorio
```bash
git clone <repository-url>
cd oftalmo-agendamiento
```

### 2. Instalar dependencias
```bash
# Dependencias de PHP
composer install

# Dependencias de Node.js
npm install
```

### 3. Configurar variables de entorno
```bash
cp .env.example .env
php artisan key:generate
```

Actualizar el archivo `.env` con tus credenciales:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=Proyecto_laravel
DB_USERNAME=postgres
DB_PASSWORD=1234

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_usuario_mailtrap
MAIL_PASSWORD=tu_contraseña_mailtrap
MAIL_FROM_ADDRESS="no-reply@oftalmo-agendamiento.test"

APPOINTMENT_DURATION_MINUTES=20
```

### 4. Ejecutar migraciones
```bash
php artisan migrate:fresh
```

### 5. Cargar datos de prueba

Ejecutar en tinker:
```bash
php artisan tinker
```

Luego copiar y ejecutar el contenido del seeder (ver DatabaseSeeder.php)

### 6. Compilar assets
```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

### 7. Iniciar servidor
```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`

## 👤 Credenciales de Acceso

**Usuario Administrador:**
- Email: `admin@oftalmo.test`
- Contraseña: `password`

**Médicos incluidos:**
- Dr. Juan Pérez (dr-juan-perez)
- Dra. María García (dra-maria-garcia)
- Dr. Carlos Rodríguez (dr-carlos-rodriguez)

## 📱 Rutas Principales

### Rutas Públicas
- `GET /` - Página principal con selector de médicos
- `GET /doctors/{slug}` - Perfil y disponibilidad del médico
- `GET /appointments/new` - Formulario de nueva cita
- `POST /appointments` - Crear cita

### Rutas Protegidas (Admin)
- `GET /home` - Dashboard administrativo
- `GET /calendar` - Calendario semanal
- `GET /appointments` - Gestión de citas
- `POST /appointments/{slug}/accept` - Aceptar cita
- `POST /appointments/{slug}/reject` - Rechazar cita
- `POST /appointments/{slug}/complete` - Completar cita
- `Resource /doctors` - CRUD de médicos

## 📊 Reglas de Negocio

### Configuración de Citas
- **Duración**: Configurable vía `.env` (APPOINTMENT_DURATION_MINUTES=20)
- **Horarios**: Definidos por médico en weekly_schedule
- **Estados**: `pending` → `confirmed` → `completed` o `pending` → `rejected`

### Validaciones
- ✅ No se permiten citas duplicadas en el mismo horario
- ✅ Las citas deben estar dentro del horario disponible del médico
- ✅ Solo citas pendientes pueden ser aceptadas/rechazadas
- ✅ Solo citas confirmadas pueden ser completadas

### Notificaciones por Email
- 📧 Al crear una cita (pending)
- 📧 Al aceptar una cita (confirmed)
- 📧 Al rechazar una cita (rejected)

## 🗂 Estructura del Proyecto

```
app/
├── Http/Controllers/
│   ├── PublicController.php          # Vista pública
│   └── Admin/
│       ├── HomeController.php        # Dashboard
│       ├── AppointmentController.php # Gestión de citas
│       ├── DoctorController.php      # Gestión de médicos
│       └── CalendarController.php    # Calendario
├── Models/
│   ├── Doctor.php                    # Modelo de médicos
│   ├── Appointment.php               # Modelo de citas
│   └── User.php                      # Modelo de usuarios
└── Mail/
    ├── AppointmentCreated.php        # Email de creación
    ├── AppointmentConfirmed.php      # Email de confirmación
    └── AppointmentRejected.php       # Email de rechazo

resources/
└── js/Pages/
    ├── Public/
    │   ├── Index.vue                 # Listado de médicos
    │   ├── DoctorProfile.vue         # Perfil y calendario
    │   └── NewAppointment.vue        # Formulario de cita
    └── Admin/
        ├── Home.vue                  # Dashboard
        ├── Calendar.vue              # Calendario semanal
        ├── Appointments/
        │   ├── Index.vue             # Listado de citas
        │   └── Show.vue              # Detalle de cita
        └── Doctors/
            └── Index.vue             # Listado de médicos
```

## 🎨 Características de Diseño

- ✅ **Responsive**: Funciona en móviles, tablets y desktop
- ✅ **Moderno**: UI limpia con TailwindCSS
- ✅ **Accesible**: Navegación intuitiva
- ✅ **Interactivo**: Calendario dinámico con Vue 3

## 🔧 Comandos Útiles

```bash
# Limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Ver rutas
php artisan route:list

# Crear nuevo médico
php artisan tinker
>>> App\Models\Doctor::factory()->create()

# Compilar assets en modo watch
npm run dev

# Verificar errores de sintaxis
composer check
```

## 📧 Configuración de Correo

El sistema usa **Mailtrap** para desarrollo. Para configurar:

1. Crear cuenta en [Mailtrap.io](https://mailtrap.io)
2. Obtener credenciales SMTP
3. Actualizar `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_username
MAIL_PASSWORD=tu_password
```

## 🐛 Solución de Problemas

### Error de conexión a la base de datos
- Verificar que PostgreSQL esté ejecutándose
- Verificar credenciales en `.env`
- Crear la base de datos si no existe

### Assets no se cargan
- Ejecutar `npm run build`
- Verificar que `/public/build` exista
- Limpiar cache del navegador

### Emails no se envían
- Verificar configuración de Mailtrap en `.env`
- Revisar logs en `storage/logs/laravel.log`

## 📝 Licencia

Este proyecto es de código abierto y está disponible bajo la licencia MIT.

## 👥 Autor

Desarrollado como proyecto de demostración para sistema de agendamiento médico.

## 🙏 Agradecimientos

- Laravel Team
- Inertia.js Team
- TailwindCSS Team
- Jetstream

---

**Nota**: Este es un proyecto de demostración. Para uso en producción, asegúrate de:
- Configurar un servidor de correo real
- Implementar medidas de seguridad adicionales
- Configurar backups automáticos de la base de datos
- Implementar rate limiting en las rutas públicas
- Añadir logs y monitoreo
