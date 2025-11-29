<template>
    <AppLayout title="Médicos">
        <template #header>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <Link href="/dashboard" class="text-indigo-600 hover:text-indigo-800">
                        ← Volver al panel
                    </Link>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Gestión de Médicos
                    </h2>
                </div>
                <Link href="/admin/doctors/create" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    + Nuevo Médico
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Especialidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="doctor in doctors.data" :key="doctor.id" class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ doctor.name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ doctor.specialty }}
                                </td>
                                <td class="px-6 py-4">
                                    <span 
                                        class="px-3 py-1 rounded-full text-xs font-semibold"
                                        :class="doctor.active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                    >
                                        {{ doctor.active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex gap-3">
                                        <Link
                                            :href="`/admin/doctors/${doctor.slug}`"
                                            class="text-indigo-600 hover:text-indigo-800"
                                        >
                                            Ver
                                        </Link>
                                        <Link
                                            :href="`/admin/doctors/${doctor.slug}/edit`"
                                            class="text-blue-600 hover:text-blue-800"
                                        >
                                            Editar
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    doctors: Object
});
</script>
