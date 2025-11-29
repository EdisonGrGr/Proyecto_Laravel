<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <Link href="/" class="text-indigo-600 hover:text-indigo-800 mb-2 inline-block">
                    ← Volver a todos los médicos
                </Link>
                <h1 class="text-3xl font-bold text-gray-900">{{ doctor.name }}</h1>
                <p class="mt-1 text-gray-600">{{ doctor.specialty }}</p>
            </div>
        </header>

        <main class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <!-- Doctor Info Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-2xl font-semibold mb-4">Horario de Atención</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div v-for="(schedule, day) in doctor.weekly_schedule" :key="day">
                        <div v-if="schedule && schedule.length > 0" class="border-b pb-2">
                            <span class="font-semibold capitalize">{{ translateDay(day) }}:</span>
                            <div class="ml-4 mt-1 text-gray-700">
                                <div v-for="(slot, idx) in schedule" :key="idx">
                                    {{ slot.start }} - {{ slot.end }}
                                </div>
                            </div>
                        </div>
                        <div v-else class="border-b pb-2">
                            <span class="font-semibold capitalize">{{ translateDay(day) }}:</span>
                            <span class="ml-2 text-gray-500">No disponible</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Weekly Calendar -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Próximos espacios disponibles</h2>
                    <div class="flex gap-2">
                        <button 
                            @click="previousWeek" 
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300"
                        >
                            ← Anterior
                        </button>
                        <button 
                            @click="nextWeek" 
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300"
                        >
                            Siguiente →
                        </button>
                    </div>
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 gap-2">
                    <div 
                        v-for="day in weekDays" 
                        :key="day.date"
                        class="border rounded p-2"
                    >
                        <div class="text-center mb-2">
                            <div class="font-semibold text-sm">{{ day.name }}</div>
                            <div class="text-xs text-gray-600">{{ day.date }}</div>
                        </div>
                        <div class="space-y-1">
                            <button
                                v-for="slot in day.availableSlots"
                                :key="slot"
                                @click="selectSlot(day.fullDate, slot)"
                                class="w-full text-xs px-2 py-1 bg-green-100 text-green-800 rounded hover:bg-green-200"
                            >
                                {{ slot }}
                            </button>
                            <div v-if="day.availableSlots.length === 0" class="text-xs text-gray-400 text-center">
                                Sin espacios
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    doctor: Object
});

const currentWeekStart = ref(new Date());
currentWeekStart.value.setHours(0, 0, 0, 0);
const dayOfWeek = currentWeekStart.value.getDay();
const diff = currentWeekStart.value.getDate() - dayOfWeek + (dayOfWeek === 0 ? -6 : 1);
currentWeekStart.value.setDate(diff);

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

const getDayKey = (date) => {
    const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    return days[date.getDay()];
};

const weekDays = computed(() => {
    const days = [];
    const dayNames = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
    
    for (let i = 0; i < 7; i++) {
        const date = new Date(currentWeekStart.value);
        date.setDate(date.getDate() + i);
        
        const dayKey = getDayKey(date);
        const schedule = props.doctor.weekly_schedule[dayKey] || [];
        const availableSlots = generateTimeSlots(schedule, date);
        
        days.push({
            name: dayNames[i],
            date: date.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit' }),
            fullDate: date,
            availableSlots
        });
    }
    
    return days;
});

const generateTimeSlots = (schedule, date) => {
    if (!schedule || schedule.length === 0) return [];
    
    const now = new Date();
    if (date < now) return [];
    
    const slots = [];
    const duration = 20; // minutos
    
    schedule.forEach(period => {
        const [startHour, startMin] = period.start.split(':').map(Number);
        const [endHour, endMin] = period.end.split(':').map(Number);
        
        let current = new Date(date);
        current.setHours(startHour, startMin, 0, 0);
        
        const end = new Date(date);
        end.setHours(endHour, endMin, 0, 0);
        
        while (current < end) {
            if (current > now) {
                const timeString = current.toTimeString().slice(0, 5);
                if (!isSlotBooked(date, timeString)) {
                    slots.push(timeString);
                }
            }
            current = new Date(current.getTime() + duration * 60000);
        }
    });
    
    return slots;
};

const isSlotBooked = (date, time) => {
    // Aquí verificarías contra las citas existentes
    // Por ahora retornamos false (todos disponibles)
    return false;
};

const selectSlot = (date, time) => {
    const [hours, minutes] = time.split(':');
    const selectedDate = new Date(date);
    selectedDate.setHours(hours, minutes, 0, 0);
    
    const startISO = selectedDate.toISOString();
    router.visit(`/appointments/new?doctor=${props.doctor.slug}&start=${startISO}`);
};

const previousWeek = () => {
    currentWeekStart.value.setDate(currentWeekStart.value.getDate() - 7);
    currentWeekStart.value = new Date(currentWeekStart.value);
};

const nextWeek = () => {
    currentWeekStart.value.setDate(currentWeekStart.value.getDate() + 7);
    currentWeekStart.value = new Date(currentWeekStart.value);
};
</script>
