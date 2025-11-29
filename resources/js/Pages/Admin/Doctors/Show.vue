<template>
    <AppLayout :title="doctor.name">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ doctor.name }}
                </h2>
                <div class="flex gap-3">
                    <Link
                        :href="`/admin/doctors/${doctor.slug}/edit`"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                    >
                        Editar
                    </Link>
                    <Link
                        href="/admin/doctors"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                    >
                        Volver
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold mb-4">Información General</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                            <p class="text-gray-900">{{ doctor.name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Especialidad</label>
                            <p class="text-gray-900">{{ doctor.specialty }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                            <span 
                                class="px-3 py-1 rounded-full text-xs font-semibold inline-block"
                                :class="doctor.active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                            >
                                {{ doctor.active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                            <p class="text-gray-600 text-sm font-mono">{{ doctor.slug }}</p>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold mb-4">Horario de Atención</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div v-for="day in daysOfWeek" :key="day.value" class="border rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-2">{{ day.label }}</h4>
                            <div v-if="doctor.weekly_schedule[day.value]" class="space-y-2">
                                <div
                                    v-for="(slot, index) in doctor.weekly_schedule[day.value]"
                                    :key="index"
                                    class="text-sm bg-indigo-50 px-3 py-2 rounded"
                                >
                                    {{ slot.start }} - {{ slot.end }}
                                </div>
                            </div>
                            <p v-else class="text-sm text-gray-500 italic">Sin horario</p>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold mb-4">Últimas 20 Citas</h3>
                    <div v-if="doctor.appointments && doctor.appointments.length > 0">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paciente</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="appointment in doctor.appointments" :key="appointment.id" class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ appointment.patient_name }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ formatDate(appointment.start) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span 
                                            class="px-3 py-1 rounded-full text-xs font-semibold"
                                            :class="getStatusClass(appointment.status)"
                                        >
                                            {{ getStatusLabel(appointment.status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <Link
                                            :href="`/admin/appointments/${appointment.slug}`"
                                            class="text-indigo-600 hover:text-indigo-800"
                                        >
                                            Ver detalles
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p v-else class="text-gray-500 text-center py-8">
                        No hay citas registradas para este médico
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    doctor: Object
});

const daysOfWeek = [
    { value: 'monday', label: 'Lunes' },
    { value: 'tuesday', label: 'Martes' },
    { value: 'wednesday', label: 'Miércoles' },
    { value: 'thursday', label: 'Jueves' },
    { value: 'friday', label: 'Viernes' },
    { value: 'saturday', label: 'Sábado' },
    { value: 'sunday', label: 'Domingo' }
];

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleString('es-ES', {
        weekday: 'short',
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const getStatusClass = (status) => {
    const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        confirmed: 'bg-green-100 text-green-800',
        rejected: 'bg-red-100 text-red-800',
        completed: 'bg-blue-100 text-blue-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const getStatusLabel = (status) => {
    const labels = {
        pending: 'Pendiente',
        confirmed: 'Confirmada',
        rejected: 'Rechazada',
        completed: 'Completada'
    };
    return labels[status] || status;
};
</script>
