<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\CalendarController;


Route::get('/', [PublicController::class, 'index'])->name('public.index');


Route::get('/doctors/{doctor:slug}', [PublicController::class, 'show'])->name('public.doctor.show');


Route::get('/appointments/new', [PublicController::class, 'newAppointment'])->name('public.appointment.new');


Route::post('/appointments', [PublicController::class, 'storeAppointment'])->name('public.appointment.store');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    
    Route::get('/dashboard', function () {
        return redirect()->route('admin.home');
    })->name('dashboard');

    
    Route::get('/home', [HomeController::class, 'index'])->name('admin.home');

    
    Route::get('/calendar', [CalendarController::class, 'index'])->name('admin.calendar');

    
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

    
    Route::resource('appointments', AdminAppointmentController::class)->except(['create', 'store'])->names([
        'index' => 'admin.appointments.index',
        'show' => 'admin.appointments.show',
        'edit' => 'admin.appointments.edit',
        'update' => 'admin.appointments.update',
        'destroy' => 'admin.appointments.destroy',
    ]);

    
    Route::post('/appointments/{appointment:slug}/accept', [AdminAppointmentController::class, 'accept'])->name('admin.appointments.accept');
    Route::post('/appointments/{appointment:slug}/reject', [AdminAppointmentController::class, 'reject'])->name('admin.appointments.reject');
    Route::post('/appointments/{appointment:slug}/complete', [AdminAppointmentController::class, 'complete'])->name('admin.appointments.complete');
});
