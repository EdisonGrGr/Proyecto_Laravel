<template>
    <AppLayout title="Gestión de Citas">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Gestión de Citas
                </h2>
                <Link href="/dashboard" class="text-indigo-600 hover:text-indigo-800">
                    ← Volver al panel
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                            <select 
                                v-model="filters.status"
                                @change="applyFilters"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Todos los estados</option>
                                <option value="pending">Pendiente</option>
                                <option value="confirmed">Confirmada</option>
                                <option value="completed">Completada</option>
                                <option value="rejected">Rechazada</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Médico</label>
                            <select 
                                v-model="filters.doctor"
                                @change="applyFilters"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Todos los médicos</option>
                                <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.slug">
                                    {{ doctor.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paciente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Médico</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha y Hora</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="appointment in appointments.data" :key="appointment.id" class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ appointment.patient_name }}</div>
                                    <div class="text-sm text-gray-500">{{ appointment.patient_email }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ appointment.doctor.name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ formatDateTime(appointment.start) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span 
                                        class="px-3 py-1 rounded-full text-xs font-semibold"
                                        :class="getStatusClass(appointment.status)"
                                    >
                                        {{ translateStatus(appointment.status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex gap-2">
                                        <button
                                            v-if="appointment.status === 'pending'"
                                            @click="acceptAppointment(appointment.slug)"
                                            class="text-green-600 hover:text-green-800"
                                        >
                                            Aceptar
                                        </button>
                                        <button
                                            v-if="appointment.status === 'pending'"
                                            @click="rejectAppointment(appointment.slug)"
                                            class="text-red-600 hover:text-red-800"
                                        >
                                            Rechazar
                                        </button>
                                        <button
                                            v-if="appointment.status === 'confirmed'"
                                            @click="completeAppointment(appointment.slug)"
                                            class="text-blue-600 hover:text-blue-800"
                                        >
                                            Completar
                                        </button>
                                        <Link
                                            :href="`/appointments/${appointment.slug}`"
                                            class="text-indigo-600 hover:text-indigo-800"
                                        >
                                            Ver
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    
                    <div v-if="appointments.links" class="bg-gray-50 px-6 py-4 border-t">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-700">
                                Mostrando {{ appointments.from }} - {{ appointments.to }} de {{ appointments.total }}
                            </div>
                            <div class="flex gap-2">
                                <Link
                                    v-for="link in appointments.links"
                                    :key="link.label"
                                    :href="link.url"
                                    :class="[
                                        'px-3 py-2 text-sm rounded',
                                        link.active 
                                            ? 'bg-indigo-600 text-white' 
                                            : 'bg-white text-gray-700 hover:bg-gray-100',
                                        !link.url && 'opacity-50 cursor-not-allowed'
                                    ]"
                                    v-html="link.label"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    appointments: Object,
    doctors: Array,
    filters: Object
});

const filters = ref({
    status: props.filters?.status || '',
    doctor: props.filters?.doctor || ''
});

const formatDateTime = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('es-ES', { 
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
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

const applyFilters = () => {
    const params = new URLSearchParams();
    if (filters.value.status) params.set('status', filters.value.status);
    if (filters.value.doctor) params.set('doctor', filters.value.doctor);
    router.visit(`/appointments?${params.toString()}`);
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

const completeAppointment = (slug) => {
    if (confirm('¿Marcar esta cita como completada?')) {
        router.post(`/appointments/${slug}/complete`);
    }
};
</script>
