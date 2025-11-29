<template>
    <AppLayout title="Detalle de Cita">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalle de Cita
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-sm p-8">
                    <div class="mb-6">
                        <Link href="/appointments" class="text-indigo-600 hover:text-indigo-800">
                            ← Volver a todas las citas
                        </Link>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Información del Paciente</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ appointment.patient_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ appointment.patient_email }}</dd>
                                </div>
                                <div v-if="appointment.patient_phone">
                                    <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ appointment.patient_phone }}</dd>
                                </div>
                            </dl>
                        </div>

                        
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Información de la Cita</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Médico</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ appointment.doctor.name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Fecha</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ formatDate(appointment.start) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Hora</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ formatTime(appointment.start) }} - {{ formatTime(appointment.end) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Estado</dt>
                                    <dd class="mt-1">
                                        <span 
                                            class="px-3 py-1 rounded-full text-xs font-semibold"
                                            :class="getStatusClass(appointment.status)"
                                        >
                                            {{ translateStatus(appointment.status) }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    
                    <div class="mt-8 pt-6 border-t border-gray-200 flex gap-4">
                        <button
                            v-if="appointment.status === 'pending'"
                            @click="acceptAppointment"
                            class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
                        >
                            Aceptar Cita
                        </button>
                        <button
                            v-if="appointment.status === 'pending'"
                            @click="rejectAppointment"
                            class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                        >
                            Rechazar Cita
                        </button>
                        <button
                            v-if="appointment.status === 'confirmed'"
                            @click="completeAppointment"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                        >
                            Marcar como Completada
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    appointment: Object
});

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('es-ES', { 
        weekday: 'long',
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    });
};

const formatTime = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
};

const getStatusClass = (status) => {
    const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        confirmed: 'bg-green-100 text-green-800',
        completed: 'bg-blue-100 text-blue-800',
        rejected: 'bg-red-100 text-red-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const translateStatus = (status) => {
    const translations = {
        pending: 'Pendiente',
        confirmed: 'Confirmada',
        completed: 'Completada',
        rejected: 'Rechazada'
    };
    return translations[status] || status;
};

const acceptAppointment = () => {
    if (confirm('¿Confirmar esta cita?')) {
        router.post(`/appointments/${props.appointment.slug}/accept`);
    }
};

const rejectAppointment = () => {
    if (confirm('¿Rechazar esta cita?')) {
        router.post(`/appointments/${props.appointment.slug}/reject`);
    }
};

const completeAppointment = () => {
    if (confirm('¿Marcar esta cita como completada?')) {
        router.post(`/appointments/${props.appointment.slug}/complete`);
    }
};
</script>
