<template>
    <AppLayout title="Panel Administrativo">
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight">Panel de Administración</h2>
                    <p class="text-sm text-gray-600 mt-1">Gestiona las citas y operaciones de la clínica</p>
                </div>
                <div class="text-sm text-gray-500">
                    {{ new Date().toLocaleDateString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div v-if="$page.props.flash?.success" class="mb-6">
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-r-lg shadow-sm flex items-center">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">{{ $page.props.flash.success }}</span>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-yellow-600 uppercase tracking-wide">Pendientes</span>
                        </div>
                        <div class="text-3xl font-bold text-yellow-700">{{ stats.pending }}</div>
                        <p class="text-xs text-yellow-600 mt-1">Por confirmar</p>
                    </div>

                    <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-green-600 uppercase tracking-wide">Confirmadas</span>
                        </div>
                        <div class="text-3xl font-bold text-green-700">{{ stats.confirmed }}</div>
                        <p class="text-xs text-green-600 mt-1">Próximamente</p>
                    </div>

                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-blue-600 uppercase tracking-wide">Completadas</span>
                        </div>
                        <div class="text-3xl font-bold text-blue-700">{{ stats.completed }}</div>
                        <p class="text-xs text-blue-600 mt-1">Finalizadas</p>
                    </div>

                    <div class="bg-gradient-to-br from-red-50 to-red-100 border border-red-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-red-600 uppercase tracking-wide">Rechazadas</span>
                        </div>
                        <div class="text-3xl font-bold text-red-700">{{ stats.rejected }}</div>
                        <p class="text-xs text-red-600 mt-1">No procesadas</p>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                    <Link href="/appointments" class="group bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-blue-300 hover:-translate-y-1">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">Gestionar Citas</h3>
                        <p class="text-gray-600 text-sm">Ver, aprobar o rechazar citas pendientes</p>
                    </Link>

                    <Link href="/calendar" class="group bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-purple-300 hover:-translate-y-1">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors">Calendario</h3>
                        <p class="text-gray-600 text-sm">Vista semanal de citas por médico</p>
                    </Link>

                    <Link href="/admin/doctors" class="group bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-green-300 hover:-translate-y-1">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">Médicos</h3>
                        <p class="text-gray-600 text-sm">Administrar médicos y horarios</p>
                    </Link>
                </div>

                
                <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-100">
                    <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Próximas Citas</h3>
                            </div>
                            <span class="text-sm text-gray-500">{{ upcomingAppointments.length }} citas</span>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <div 
                            v-for="appointment in upcomingAppointments" 
                            :key="appointment.id"
                            class="p-5 hover:bg-blue-50/50 transition-colors"
                        >
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                                        <span 
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold"
                                            :class="{
                                                'bg-yellow-100 text-yellow-800 border border-yellow-200': appointment.status === 'pending',
                                                'bg-green-100 text-green-800 border border-green-200': appointment.status === 'confirmed'
                                            }"
                                        >
                                            <span class="w-1.5 h-1.5 rounded-full mr-1.5" :class="{
                                                'bg-yellow-500': appointment.status === 'pending',
                                                'bg-green-500': appointment.status === 'confirmed'
                                            }"></span>
                                            {{ appointment.status === 'pending' ? 'Pendiente' : 'Confirmada' }}
                                        </span>
                                        <span class="text-sm font-semibold text-blue-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ appointment.doctor.name }}
                                        </span>
                                    </div>
                                    <p class="text-gray-900 font-bold text-lg mb-1">{{ appointment.patient_name }}</p>
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3 text-sm text-gray-600">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            {{ appointment.patient_email }}
                                        </span>
                                        <span class="flex items-center font-medium text-gray-700">
                                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ formatDateTime(appointment.start) }}
                                        </span>
                                    </div>
                                </div>
                                <div v-if="appointment.status === 'pending'" class="flex flex-col sm:flex-row gap-2 flex-shrink-0">
                                    <button
                                        @click="acceptAppointment(appointment.slug)"
                                        class="flex items-center justify-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors shadow-sm hover:shadow"
                                    >
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Aceptar
                                    </button>
                                    <button
                                        @click="rejectAppointment(appointment.slug)"
                                        class="flex items-center justify-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm hover:shadow"
                                    >
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Rechazar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div v-if="upcomingAppointments.length === 0" class="p-12 text-center">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500 font-medium">No hay citas próximas</p>
                            <p class="text-sm text-gray-400 mt-1">Las nuevas citas aparecerán aquí</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
    stats: Object,
    upcomingAppointments: Array,
    doctors: Array
});

const formatDateTime = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('es-ES', { 
        weekday: 'short',
        day: '2-digit', 
        month: 'short',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const acceptAppointment = (slug) => {
    if (confirm('¿Confirmar esta cita?')) {
        router.post(`/appointments/${slug}/accept`);
    }
};

const rejectAppointment = (slug) => {
    if (confirm('¿Rechazar esta cita?')) {
        router.post(`/appointments/${slug}/reject`);
    }
};
</script>
