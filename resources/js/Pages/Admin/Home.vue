<template>
    <AppLayout title="Panel Administrativo">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Panel de Administración
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div v-if="$page.props.flash?.success" class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ $page.props.flash.success }}
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                        <div class="text-sm font-medium text-gray-500">Citas Pendientes</div>
                        <div class="mt-2 text-3xl font-semibold text-yellow-600">{{ stats.pending }}</div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                        <div class="text-sm font-medium text-gray-500">Citas Confirmadas</div>
                        <div class="mt-2 text-3xl font-semibold text-green-600">{{ stats.confirmed }}</div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                        <div class="text-sm font-medium text-gray-500">Citas Completadas</div>
                        <div class="mt-2 text-3xl font-semibold text-blue-600">{{ stats.completed }}</div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                        <div class="text-sm font-medium text-gray-500">Citas Rechazadas</div>
                        <div class="mt-2 text-3xl font-semibold text-red-600">{{ stats.rejected }}</div>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <Link href="/appointments" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <h3 class="text-lg font-semibold mb-2">Gestionar Citas</h3>
                        <p class="text-gray-600 text-sm">Ver, aprobar o rechazar citas pendientes</p>
                    </Link>
                    <Link href="/calendar" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <h3 class="text-lg font-semibold mb-2">Calendario</h3>
                        <p class="text-gray-600 text-sm">Vista semanal de citas por médico</p>
                    </Link>
                    <Link href="/admin/doctors" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <h3 class="text-lg font-semibold mb-2">Médicos</h3>
                        <p class="text-gray-600 text-sm">Administrar médicos y horarios</p>
                    </Link>
                </div>

                
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold">Próximas Citas</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div 
                            v-for="appointment in upcomingAppointments" 
                            :key="appointment.id"
                            class="p-6 hover:bg-gray-50"
                        >
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span 
                                            class="px-3 py-1 rounded-full text-xs font-semibold"
                                            :class="{
                                                'bg-yellow-100 text-yellow-800': appointment.status === 'pending',
                                                'bg-green-100 text-green-800': appointment.status === 'confirmed'
                                            }"
                                        >
                                            {{ appointment.status === 'pending' ? 'Pendiente' : 'Confirmada' }}
                                        </span>
                                        <span class="text-sm font-medium">{{ appointment.doctor.name }}</span>
                                    </div>
                                    <p class="text-gray-900 font-semibold">{{ appointment.patient_name }}</p>
                                    <p class="text-sm text-gray-600">{{ appointment.patient_email }}</p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ formatDateTime(appointment.start) }}
                                    </p>
                                </div>
                                <div v-if="appointment.status === 'pending'" class="flex gap-2">
                                    <button
                                        @click="acceptAppointment(appointment.slug)"
                                        class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700"
                                    >
                                        Aceptar
                                    </button>
                                    <button
                                        @click="rejectAppointment(appointment.slug)"
                                        class="px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700"
                                    >
                                        Rechazar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div v-if="upcomingAppointments.length === 0" class="p-6 text-center text-gray-500">
                            No hay citas próximas
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
