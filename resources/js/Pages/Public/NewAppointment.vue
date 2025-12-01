<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 flex flex-col relative">
        <!-- Patrón decorativo de fondo -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <svg class="absolute w-full h-full opacity-[0.03]" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="1" class="text-blue-600"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
            <div class="absolute top-20 right-10 w-64 h-64 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-40 left-20 w-72 h-72 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-20 left-1/2 w-64 h-64 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>
        <!-- Header with Logo -->
        <header class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
            <div class="max-w-3xl mx-auto py-2.5 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-base font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                Clínica Oftalmológica
                            </h1>
                            <p class="text-[10px] text-gray-600">Confirmar Cita</p>
                        </div>
                    </div>
                    <Link :href="`/doctors/${doctor.slug}`" class="flex items-center text-sm text-gray-600 hover:text-blue-600 transition-colors font-medium">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span class="hidden sm:inline">Volver</span>
                    </Link>
                </div>
            </div>
        </header>

        <main class="max-w-2xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex-1 relative z-10">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <!-- Appointment Details - Compact -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 sm:px-5 py-3.5">
                    <div class="flex items-center text-white mb-2.5">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h2 class="text-base font-bold">Detalles de la cita</h2>
                    </div>
                    <div class="grid grid-cols-2 gap-2.5 text-sm">
                        <div class="bg-white rounded-lg p-2.5 shadow-sm">
                            <span class="text-gray-600 text-[11px] font-medium block mb-0.5">Médico:</span>
                            <p class="font-bold text-gray-900 text-sm">{{ doctor.name }}</p>
                        </div>
                        <div class="bg-white rounded-lg p-2.5 shadow-sm">
                            <span class="text-gray-600 text-[11px] font-medium block mb-0.5">Especialidad:</span>
                            <p class="font-bold text-gray-900 text-sm">{{ doctor.specialty }}</p>
                        </div>
                        <div class="bg-white rounded-lg p-2.5 shadow-sm">
                            <span class="text-gray-600 text-[11px] font-medium block mb-0.5">Fecha:</span>
                            <p class="font-bold text-gray-900 text-sm">{{ formatDate(start) }}</p>
                        </div>
                        <div class="bg-white rounded-lg p-2.5 shadow-sm">
                            <span class="text-gray-600 text-[11px] font-medium block mb-0.5">Hora:</span>
                            <p class="font-bold text-blue-600 text-base">{{ formatTime(start) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Patient Form -->
                <form @submit.prevent="submitAppointment" class="p-4 sm:p-5">
                    <div class="mb-4">
                        <div class="flex items-center mb-3">
                            <svg class="w-4 h-4 text-blue-600 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <h3 class="text-sm font-bold text-gray-900">Información del Paciente</h3>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label for="patient_name" class="block text-xs font-semibold text-gray-700 mb-1">
                                Nombre completo *
                            </label>
                            <input
                                id="patient_name"
                                v-model="form.patient_name"
                                type="text"
                                required
                                placeholder="Ingrese su nombre completo"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                :class="{ 'border-red-500 ring-2 ring-red-200': form.errors.patient_name }"
                            />
                            <p v-if="form.errors.patient_name" class="mt-1.5 text-xs text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ form.errors.patient_name }}
                            </p>
                        </div>

                        <div>
                            <label for="patient_email" class="block text-xs font-semibold text-gray-700 mb-1">
                                Correo electrónico *
                            </label>
                            <input
                                id="patient_email"
                                v-model="form.patient_email"
                                type="email"
                                required
                                placeholder="correo@ejemplo.com"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                :class="{ 'border-red-500 ring-2 ring-red-200': form.errors.patient_email }"
                            />
                            <p v-if="form.errors.patient_email" class="mt-1.5 text-xs text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ form.errors.patient_email }}
                            </p>
                        </div>

                        <div>
                            <label for="patient_phone" class="block text-xs font-semibold text-gray-700 mb-1">
                                Teléfono <span class="text-gray-500 font-normal">(opcional)</span>
                            </label>
                            <input
                                id="patient_phone"
                                v-model="form.patient_phone"
                                type="tel"
                                placeholder="Ej: 300 123 4567"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            />
                        </div>

                        <div v-if="form.errors.start" class="p-3 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <p class="text-sm text-red-700 font-medium">{{ form.errors.start }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-2.5 pt-3">
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="flex-1 flex items-center justify-center bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-2.5 px-5 rounded-lg hover:from-blue-700 hover:to-indigo-700 disabled:from-gray-400 disabled:to-gray-400 disabled:cursor-not-allowed font-semibold shadow-lg hover:shadow-xl transition-all transform hover:scale-[1.02] disabled:transform-none">
                            >
                                <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <svg v-else class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ form.processing ? 'Procesando...' : 'Confirmar Cita' }}
                            </button>
                            <Link
                                :href="`/doctors/${doctor.slug}`"
                                class="flex-1 flex items-center justify-center bg-gray-100 text-gray-700 py-2.5 px-5 rounded-lg hover:bg-gray-200 border border-gray-300 font-semibold transition-all">
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancelar
                            </Link>
                        </div>
                    </div>

                    <div class="mt-4 p-2.5 bg-blue-50 rounded-lg border border-blue-100">
                        <div class="flex items-start">
                            <svg class="w-4 h-4 text-blue-600 mr-1.5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-[11px] text-gray-700 leading-relaxed">
                                Recibirás un correo de confirmación con los detalles de tu cita. Por favor revisa tu bandeja de entrada.
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </main>

        <!-- Footer profesional -->
        <Footer class="relative z-10" />
    </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import Footer from '@/Components/Footer.vue';

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
