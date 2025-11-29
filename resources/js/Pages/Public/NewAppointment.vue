<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
        <header class="bg-white shadow">
            <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <Link :href="`/doctors/${doctor.slug}`" class="text-indigo-600 hover:text-indigo-800 mb-2 inline-block">
                    ← Volver al calendario
                </Link>
                <h1 class="text-3xl font-bold text-gray-900">Confirmar Cita</h1>
            </div>
        </header>

        <main class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-8">
                <!-- Appointment Details -->
                <div class="mb-8 p-4 bg-indigo-50 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4">Detalles de la cita</h2>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-semibold">Médico:</span>
                            <p>{{ doctor.name }}</p>
                        </div>
                        <div>
                            <span class="font-semibold">Especialidad:</span>
                            <p>{{ doctor.specialty }}</p>
                        </div>
                        <div>
                            <span class="font-semibold">Fecha:</span>
                            <p>{{ formatDate(start) }}</p>
                        </div>
                        <div>
                            <span class="font-semibold">Hora:</span>
                            <p>{{ formatTime(start) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Patient Form -->
                <form @submit.prevent="submitAppointment">
                    <div class="space-y-6">
                        <div>
                            <label for="patient_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre completo *
                            </label>
                            <input
                                id="patient_name"
                                v-model="form.patient_name"
                                type="text"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                :class="{ 'border-red-500': form.errors.patient_name }"
                            />
                            <p v-if="form.errors.patient_name" class="mt-1 text-sm text-red-600">
                                {{ form.errors.patient_name }}
                            </p>
                        </div>

                        <div>
                            <label for="patient_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Correo electrónico *
                            </label>
                            <input
                                id="patient_email"
                                v-model="form.patient_email"
                                type="email"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                :class="{ 'border-red-500': form.errors.patient_email }"
                            />
                            <p v-if="form.errors.patient_email" class="mt-1 text-sm text-red-600">
                                {{ form.errors.patient_email }}
                            </p>
                        </div>

                        <div>
                            <label for="patient_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Teléfono (opcional)
                            </label>
                            <input
                                id="patient_phone"
                                v-model="form.patient_phone"
                                type="tel"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                            />
                        </div>

                        <div v-if="form.errors.start" class="p-4 bg-red-50 border border-red-200 rounded-md">
                            <p class="text-sm text-red-600">{{ form.errors.start }}</p>
                        </div>

                        <div class="flex gap-4">
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="flex-1 bg-indigo-600 text-white py-3 px-6 rounded-md hover:bg-indigo-700 disabled:bg-gray-400 font-semibold"
                            >
                                {{ form.processing ? 'Procesando...' : 'Confirmar Cita' }}
                            </button>
                            <Link
                                :href="`/doctors/${doctor.slug}`"
                                class="flex-1 bg-gray-200 text-gray-700 py-3 px-6 rounded-md hover:bg-gray-300 text-center font-semibold"
                            >
                                Cancelar
                            </Link>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    doctor: Object,
    start: String
});

const form = useForm({
    doctor_id: props.doctor.id,
    patient_name: '',
    patient_email: '',
    patient_phone: '',
    start: props.start
});

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('es-ES', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
};

const formatTime = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
};

const submitAppointment = () => {
    form.post('/appointments', {
        preserveScroll: true,
        onSuccess: () => {
            // La redirección la maneja el servidor
        }
    });
};
</script>
