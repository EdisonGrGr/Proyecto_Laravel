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


## Credenciales de Acceso

### Panel Administrativo
- **URL:** http://127.0.0.1:8000/login
- **Email:** admin@oftalmo.ucaldas.edu.co
- **Contraseña:** password


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


## Notas

- Las citas tienen una duración configurable (por defecto 20 minutos) en `.env`
- Los horarios de médicos se almacenan en formato JSON para mayor flexibilidad
- Se implementó un sistema de slugs para URLs amigables

## Autores

**Jhon Edison Garcia - Jose Daniel Arias**  
Universidad de Caldas - Ingeniería Informatica  

## 🚀 Despliegue en Producción

Para desplegar este proyecto en un servidor gratuito, consulta la guía completa en:

**[DEPLOYMENT.md](./DEPLOYMENT.md)** - Guía paso a paso para desplegar en Railway (recomendado)

### Resumen rápido:
1. Crea cuenta en [Railway.app](https://railway.app)
2. Conecta tu repositorio de GitHub
3. Agrega PostgreSQL desde Railway
4. Configura las variables de entorno
5. ¡Despliega automáticamente!

Railway ofrece:
- ✅ 500 horas/mes gratis
- ✅ PostgreSQL incluido
- ✅ Dominio HTTPS automático
- ✅ Despliegue continuo desde Git

## 📄 Licencia

Este proyecto fue desarrollado con fines académicos.  
Laravel framework: [MIT license](https://opensource.org/licenses/MIT)
