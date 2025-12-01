<template>
    <AppLayout title="Calendario de Citas">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Calendario Semanal
                </h2>
                <Link href="/dashboard" class="text-indigo-600 hover:text-indigo-800">
                    ← Volver al panel
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        
                        <div class="flex items-center gap-4">
                            <label class="text-sm font-medium text-gray-700">Médico:</label>
                            <select 
                                v-model="selectedDoctor"
                                @change="filterByDoctor"
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Todos los médicos</option>
                                <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.slug">
                                    {{ doctor.name }}
                                </option>
                            </select>
                        </div>

                        
                        <div class="flex items-center gap-4">
                            <button 
                                @click="previousWeek"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300"
                            >
                                ← Anterior
                            </button>
                            <span class="text-sm font-medium">
                                {{ formatWeekRange(weekStart) }}
                            </span>
                            <button 
                                @click="nextWeek"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300"
                            >
                                Siguiente →
                            </button>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="grid grid-cols-8 border-b border-gray-200">
                        <div class="p-4 bg-gray-50 font-semibold text-sm">Hora</div>
                        <div 
                            v-for="day in weekDays"
                            :key="day.date"
                            class="p-4 bg-gray-50 font-semibold text-sm text-center"
                        >
                            <div>{{ day.name }}</div>
                            <div class="text-xs text-gray-600 mt-1">{{ day.date }}</div>
                        </div>
                    </div>

                    
                    <div 
                        v-for="hour in hours"
                        :key="hour"
                        class="grid grid-cols-8 border-b border-gray-200 hover:bg-gray-50"
                    >
                        <div class="p-3 bg-gray-50 text-sm text-gray-600 border-r">
                            {{ hour }}:00
                        </div>
                        <div 
                            v-for="day in weekDays"
                            :key="`${day.date}-${hour}`"
                            class="p-2 border-r min-h-[80px] relative"
                        >
                            <div
                                v-for="appointment in getAppointmentsForSlot(day.fullDate, hour)"
                                :key="appointment.id"
                                class="mb-1 p-2 rounded text-xs cursor-pointer"
                                :class="{
                                    'bg-yellow-100 border border-yellow-300': appointment.status === 'pending',
                                    'bg-green-100 border border-green-300': appointment.status === 'confirmed'
                                }"
                                @click="showAppointmentDetails(appointment)"
                            >
                                <div class="font-semibold truncate">{{ appointment.patient_name }}</div>
                                <div class="text-gray-600 truncate">{{ formatTime(appointment.start) }}</div>
                                <div class="text-gray-500 truncate text-xs">{{ appointment.doctor.name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    appointments: Array,
    doctors: Array,
    weekStart: String,
    weekEnd: String,
    selectedDoctor: String
});

const selectedDoctor = ref(props.selectedDoctor || '');
const currentWeekStart = ref(new Date(props.weekStart));

const hours = Array.from({ length: 12 }, (_, i) => i + 8); 

const weekDays = computed(() => {
    const days = [];
    const dayNames = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
    
    for (let i = 0; i < 7; i++) {
        const date = new Date(currentWeekStart.value);
        date.setDate(date.getDate() + i);
        
        days.push({
            name: dayNames[date.getDay()],
            date: date.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit' }),
            fullDate: date
        });
    }
    
    return days;
});

const getAppointmentsForSlot = (date, hour) => {
    return props.appointments.filter(apt => {
        const aptDate = new Date(apt.start);
        const isSameDay = aptDate.getFullYear() === date.getFullYear() &&
                         aptDate.getMonth() === date.getMonth() &&
                         aptDate.getDate() === date.getDate();
        const isSameHour = aptDate.getHours() === hour;
        
        return isSameDay && isSameHour;
    });
};

const formatTime = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
};

const formatWeekRange = (weekStart) => {
    const start = new Date(weekStart);
    const end = new Date(start);
    end.setDate(end.getDate() + 6);
    
    return `${start.toLocaleDateString('es-ES', { day: '2-digit', month: 'short' })} - ${end.toLocaleDateString('es-ES', { day: '2-digit', month: 'short', year: 'numeric' })}`;
};

const filterByDoctor = () => {
    const params = new URLSearchParams();
    if (selectedDoctor.value) {
        params.set('doctor', selectedDoctor.value);
    }
    router.visit(`/calendar?${params.toString()}`);
};

const previousWeek = () => {
    const newStart = new Date(currentWeekStart.value);
    newStart.setDate(newStart.getDate() - 7);
    
    const params = new URLSearchParams();
    params.set('week', newStart.toISOString());
    if (selectedDoctor.value) {
        params.set('doctor', selectedDoctor.value);
    }
    router.visit(`/calendar?${params.toString()}`);
};

const nextWeek = () => {
    const newStart = new Date(currentWeekStart.value);
    newStart.setDate(newStart.getDate() + 7);
    
    const params = new URLSearchParams();
    params.set('week', newStart.toISOString());
    if (selectedDoctor.value) {
        params.set('doctor', selectedDoctor.value);
    }
    router.visit(`/calendar?${params.toString()}`);
};

const showAppointmentDetails = (appointment) => {
    router.visit(`/appointments/${appointment.slug}`);
};
</script>
