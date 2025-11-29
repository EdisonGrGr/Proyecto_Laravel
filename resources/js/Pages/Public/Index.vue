<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Sistema de Agendamiento</h1>
                    <p class="mt-1 text-sm text-gray-600">Oftalmología - Reserva tu cita</p>
                </div>
                <a v-if="$page.props.auth.user" href="/home" class="text-indigo-600 hover:text-indigo-800">
                    Panel Admin
                </a>
                <a v-else href="/login" class="text-indigo-600 hover:text-indigo-800">
                    Iniciar Sesión
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            <div v-if="$page.props.flash?.success" class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ $page.props.flash.success }}
            </div>

            <!-- Intro -->
            <div class="text-center mb-12">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Selecciona un médico para agendar tu cita</h2>
                <p class="text-gray-600">Contamos con especialistas en oftalmología disponibles para atenderte</p>
            </div>

            <!-- Doctors Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div 
                    v-for="doctor in doctors" 
                    :key="doctor.id"
                    class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden"
                >
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">{{ doctor.name }}</h3>
                                <p class="text-sm text-gray-600">{{ doctor.specialty }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-700 mb-2"><strong>Horarios disponibles:</strong></p>
                            <div class="text-xs text-gray-600 space-y-1">
                                <div v-for="(schedule, day) in doctor.weekly_schedule" :key="day">
                                    <span v-if="schedule && schedule.length > 0" class="capitalize">
                                        <strong>{{ translateDay(day) }}:</strong> 
                                        <span v-for="(slot, idx) in schedule" :key="idx">
                                            {{ slot.start }} - {{ slot.end }}
                                            <span v-if="idx < schedule.length - 1">, </span>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <Link 
                            :href="`/doctors/${doctor.slug}`"
                            class="block w-full text-center bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition-colors"
                        >
                            Ver disponibilidad y agendar
                        </Link>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white mt-12">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-600 text-sm">
                    © {{ new Date().getFullYear() }} Sistema de Agendamiento Oftalmológico
                </p>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    doctors: Array
});

const translateDay = (day) => {
    const days = {
        monday: 'Lunes',
        tuesday: 'Martes',
        wednesday: 'Miércoles',
        thursday: 'Jueves',
        friday: 'Viernes',
        saturday: 'Sábado',
        sunday: 'Domingo'
    };
    return days[day] || day;
};
</script>
