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
        <!-- Header -->
        <header class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <!-- Icon/Logo -->
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                Clínica Oftalmológica
                            </h1>
                            <p class="text-xs sm:text-sm text-gray-600 font-medium">Tu visión, nuestra prioridad</p>
                        </div>
                    </div>
                    <a 
                        v-if="$page.props.auth.user" 
                        href="/home" 
                        class="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-300 shadow-md hover:shadow-lg text-sm font-medium"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="hidden sm:inline">Panel Admin</span>
                    </a>
                    <a 
                        v-else 
                        href="/login" 
                        class="flex items-center space-x-2 px-4 py-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-300 text-sm font-medium"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span>Iniciar Sesión</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 flex-1 relative z-10">
            <!-- Success Message -->
            <div v-if="$page.props.flash?.success" class="mt-6 mb-4">
                <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-r-lg shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">{{ $page.props.flash.success }}</span>
                </div>
            </div>

            <!-- Hero Section -->
            <div class="text-center py-8 sm:py-12 px-4">
                <div class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded-full text-xs font-medium mb-4 shadow-sm">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Sistema de Citas en Línea
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 leading-tight">
                    Agenda tu Cita con
                    <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Nuestros Especialistas
                    </span>
                </h2>
                <p class="text-sm sm:text-base text-gray-600 max-w-2xl mx-auto mb-6 leading-relaxed">
                    Contamos con oftalmólogos certificados especializados en todas las áreas de la salud visual.
                    Reserva tu consulta de forma rápida y sencilla.
                </p>

                <!-- Search Section -->
                <div class="max-w-2xl mx-auto mb-8">
                    <div class="bg-white rounded-xl shadow-lg p-3 sm:p-4">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input 
                                type="text" 
                                v-model="searchQuery"
                                placeholder="Buscar por nombre de médico..."
                                class="w-full pl-11 pr-4 py-3 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Doctors Grid -->
            <div class="pb-16">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    <div 
                        v-for="doctor in filteredDoctors" 
                        :key="doctor.id"
                        class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-300 hover:-translate-y-1"
                    >
                        <!-- Doctor Card Header with Gradient -->
                        <div class="h-20 bg-gradient-to-br from-blue-500 to-indigo-600 relative overflow-hidden">
                            <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="absolute top-2 right-2">
                                <span class="inline-flex items-center px-2 py-1 bg-green-500 text-white text-xs font-medium rounded-full shadow">
                                    <span class="w-1.5 h-1.5 bg-white rounded-full mr-1.5 animate-pulse"></span>
                                    Disponible
                                </span>
                            </div>
                        </div>

                        <!-- Doctor Avatar -->
                        <div class="relative px-4 -mt-10">
                            <div class="w-20 h-20 bg-white rounded-xl shadow-lg flex items-center justify-center ring-4 ring-white">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Doctor Info -->
                        <div class="px-4 pt-3 pb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-0.5 group-hover:text-blue-600 transition-colors truncate">
                                {{ doctor.name }}
                            </h3>
                            <p class="text-xs font-medium text-blue-600 mb-3 flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                <span class="truncate">{{ doctor.specialty }}</span>
                            </p>

                            <!-- Schedule Info - Modern -->
                            <div class="mb-3 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-3 border border-blue-100">
                                <p class="text-xs font-semibold text-gray-700 mb-2.5 flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Días disponibles
                                </p>
                                <div class="flex flex-wrap gap-1.5 mb-2.5">
                                    <span 
                                        v-for="(schedule, day) in doctor.weekly_schedule" 
                                        :key="day"
                                        v-if="schedule && schedule.length > 0"
                                        class="inline-flex items-center px-2 py-0.5 bg-white border border-blue-200 text-blue-700 rounded text-xs font-medium"
                                    >
                                        {{ translateDay(day).substring(0, 3) }}
                                    </span>
                                </div>
                                <div class="flex items-center text-xs text-gray-600">
                                    <svg class="w-3.5 h-3.5 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium">{{ getScheduleSummary(doctor.weekly_schedule) }}</span>
                                </div>
                            </div>

                            <!-- CTA Button -->
                            <Link 
                                :href="`/doctors/${doctor.slug}`"
                                class="flex items-center justify-center w-full text-center bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-2 px-3 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-medium text-sm shadow-sm hover:shadow-md transform hover:scale-[1.02] group"
                            >
                                <span>Agendar cita</span>
                                <svg class="w-4 h-4 ml-1.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- No Results -->
                <div v-if="filteredDoctors.length === 0" class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-600 text-lg">No se encontraron especialistas con los criterios de búsqueda.</p>
                </div>
            </div>
        </main>

        <!-- Footer profesional -->
        <Footer class="relative z-10" />
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Footer from '@/Components/Footer.vue';

const props = defineProps({
    doctors: Array
});

const searchQuery = ref('');

const filteredDoctors = computed(() => {
    return props.doctors.filter(doctor => {
        const matchesSearch = !searchQuery.value || 
            doctor.name.toLowerCase().includes(searchQuery.value.toLowerCase());
        
        return matchesSearch;
    });
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

const getScheduleSummary = (schedule) => {
    const availableDays = Object.entries(schedule).filter(([_, slots]) => slots && slots.length > 0);
    
    if (availableDays.length === 0) return 'No disponible';
    
    // Obtener el rango de horas más común
    const allSlots = availableDays.flatMap(([_, slots]) => slots);
    const earliestStart = allSlots.reduce((min, slot) => 
        slot.start < min ? slot.start : min, '23:59');
    const latestEnd = allSlots.reduce((max, slot) => 
        slot.end > max ? slot.end : max, '00:00');
    
    return `Horarios: ${earliestStart} - ${latestEnd}`;
};
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
