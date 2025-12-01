<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\CalendarController;

// ===== RUTAS PÚBLICAS =====

// Página principal: selector de médicos y calendario
Route::get('/', [PublicController::class, 'index'])->name('public.index');

// Perfil de médico con disponibilidad
Route::get('/doctors/{doctor:slug}', [PublicController::class, 'show'])->name('public.doctor.show');

// Formulario para nueva cita
Route::get('/appointments/new', [PublicController::class, 'newAppointment'])->name('public.appointment.new');

// Crear cita
Route::post('/appointments', [PublicController::class, 'storeAppointment'])->name('public.appointment.store');

// ===== RUTAS PROTEGIDAS (PANEL ADMINISTRATIVO) =====

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // Dashboard redirige a /home
    Route::get('/dashboard', function () {
        return redirect()->route('admin.home');
    })->name('dashboard');

    // Home del panel: resumen de citas pendientes y confirmadas
    Route::get('/home', [HomeController::class, 'index'])->name('admin.home');

    // Calendario semanal con filtro por médico
    Route::get('/calendar', [CalendarController::class, 'index'])->name('admin.calendar');

    // CRUD de médicos
    Route::resource('admin/doctors', AdminDoctorController::class)->parameters([
        'doctors' => 'doctor:slug'
    ])->names([
        'index' => 'admin.doctors.index',
        'create' => 'admin.doctors.create',
        'store' => 'admin.doctors.store',
        'show' => 'admin.doctors.show',
        'edit' => 'admin.doctors.edit',
        'update' => 'admin.doctors.update',
        'destroy' => 'admin.doctors.destroy',
    ]);

    // Gestión de citas
    Route::resource('appointments', AdminAppointmentController::class)->except(['create', 'store'])->names([
        'index' => 'admin.appointments.index',
        'show' => 'admin.appointments.show',
        'edit' => 'admin.appointments.edit',
        'update' => 'admin.appointments.update',
        'destroy' => 'admin.appointments.destroy',
    ]);

    // Acciones sobre citas
    Route::post('/appointments/{appointment:slug}/accept', [AdminAppointmentController::class, 'accept'])->name('admin.appointments.accept');
    Route::post('/appointments/{appointment:slug}/reject', [AdminAppointmentController::class, 'reject'])->name('admin.appointments.reject');
    Route::post('/appointments/{appointment:slug}/complete', [AdminAppointmentController::class, 'complete'])->name('admin.appointments.complete');
});
