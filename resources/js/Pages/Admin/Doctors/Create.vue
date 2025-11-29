<template>
    <AppLayout title="Crear Médico">
        <template #header>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <Link
                        href="/admin/doctors"
                        class="text-indigo-600 hover:text-indigo-800"
                    >
                        ← Volver a médicos
                    </Link>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Crear Nuevo Médico
                    </h2>
                </div>
                <Link
                    href="/admin/doctors"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                >
                    Cancelar
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <form @submit.prevent="submit">
                        
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">Información Básica</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Nombre completo *
                                    </label>
                                    <input
                                        v-model="form.name"
                                        type="text"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required
                                    />
                                    <p v-if="form.errors.name" class="text-red-600 text-sm mt-1">
                                        {{ form.errors.name }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Especialidad *
                                    </label>
                                    <input
                                        v-model="form.specialty"
                                        type="text"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required
                                    />
                                    <p v-if="form.errors.specialty" class="text-red-600 text-sm mt-1">
                                        {{ form.errors.specialty }}
                                    </p>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="flex items-center">
                                        <input
                                            v-model="form.active"
                                            type="checkbox"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        />
                                        <span class="ml-2 text-sm text-gray-700">Médico activo</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">Horario de Atención</h3>
                            <div class="space-y-4">
                                <div v-for="day in daysOfWeek" :key="day.value" class="border rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-medium text-gray-900">{{ day.label }}</h4>
                                        <button
                                            type="button"
                                            @click="addTimeSlot(day.value)"
                                            class="text-sm text-indigo-600 hover:text-indigo-800"
                                        >
                                            + Agregar horario
                                        </button>
                                    </div>
                                    
                                    <div
                                        v-for="(slot, index) in form.weekly_schedule[day.value]"
                                        :key="index"
                                        class="flex gap-3 items-center mb-2"
                                    >
                                        <input
                                            v-model="slot.start"
                                            type="time"
                                            class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            required
                                        />
                                        <span class="text-gray-500">-</span>
                                        <input
                                            v-model="slot.end"
                                            type="time"
                                            class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            required
                                        />
                                        <button
                                            type="button"
                                            @click="removeTimeSlot(day.value, index)"
                                            class="text-red-600 hover:text-red-800"
                                        >
                                            Eliminar
                                        </button>
                                    </div>
                                    
                                    <p v-if="!form.weekly_schedule[day.value] || form.weekly_schedule[day.value].length === 0" class="text-sm text-gray-500 italic">
                                        Sin horarios configurados
                                    </p>
                                </div>
                            </div>
                        </div>

                        
                        <div class="flex justify-end gap-3">
                            <Link
                                href="/admin/doctors"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                            >
                                Cancelar
                            </Link>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50"
                            >
                                {{ form.processing ? 'Guardando...' : 'Crear Médico' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

const daysOfWeek = [
    { value: 'monday', label: 'Lunes' },
    { value: 'tuesday', label: 'Martes' },
    { value: 'wednesday', label: 'Miércoles' },
    { value: 'thursday', label: 'Jueves' },
    { value: 'friday', label: 'Viernes' },
    { value: 'saturday', label: 'Sábado' },
    { value: 'sunday', label: 'Domingo' }
];

const form = useForm({
    name: '',
    specialty: '',
    active: true,
    weekly_schedule: {
        monday: [],
        tuesday: [],
        wednesday: [],
        thursday: [],
        friday: [],
        saturday: [],
        sunday: []
    }
});

const addTimeSlot = (day) => {
    form.weekly_schedule[day].push({ start: '09:00', end: '17:00' });
};

const removeTimeSlot = (day, index) => {
    form.weekly_schedule[day].splice(index, 1);
};

const submit = () => {
    form.post('/admin/doctors', {
        preserveScroll: true
    });
};
</script>
