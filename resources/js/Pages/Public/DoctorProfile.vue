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
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                Clínica Oftalmológica
                            </h1>
                            <p class="text-xs text-gray-600">Sistema de Agendamiento</p>
                        </div>
                    </div>
                    <Link href="/" class="flex items-center text-sm text-gray-600 hover:text-blue-600 transition-colors font-medium">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span class="hidden sm:inline">Volver</span>
                    </Link>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex-1 relative z-10">
            <!-- Doctor Info Card - Compact -->
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 mb-6 border border-gray-100">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <!-- Avatar -->
                    <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-2xl flex items-center justify-center shadow-md flex-shrink-0">
                        <svg class="w-12 h-12 sm:w-14 sm:h-14 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    
                    <!-- Doctor Info -->
                    <div class="flex-1">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1">{{ doctor.name }}</h2>
                        <p class="text-sm sm:text-base text-blue-600 font-medium flex items-center mb-3">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            {{ doctor.specialty }}
                        </p>
                        
                        <!-- Quick Schedule Summary -->
                        <div class="flex flex-wrap gap-2">
                            <span 
                                v-for="(schedule, day) in doctor.weekly_schedule" 
                                :key="day"
                                v-if="schedule && schedule.length > 0"
                                class="inline-flex items-center px-2.5 py-1 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 text-blue-700 rounded-lg text-xs font-medium"
                            >
                                {{ translateDay(day).substring(0, 3) }}
                            </span>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="sm:self-start">
                        <span class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold border border-green-200">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            Disponible
                        </span>
                    </div>
                </div>
            </div>

            <!-- Weekly Calendar -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <!-- Calendar Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 sm:px-6 py-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center text-white">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <h2 class="text-xl font-bold">Horarios Disponibles</h2>
                                <p class="text-sm text-blue-100">{{ currentWeekRange }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button 
                                @click="previousWeek" 
                                class="flex items-center px-3 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-all text-sm font-medium backdrop-blur-sm"
                            >
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                <span class="hidden sm:inline">Anterior</span>
                            </button>
                            <button 
                                @click="nextWeek" 
                                class="flex items-center px-3 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-all text-sm font-medium backdrop-blur-sm"
                            >
                                <span class="hidden sm:inline">Siguiente</span>
                                <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Calendar Grid - Desktop -->
                <div class="hidden lg:block p-4">
                    <div class="grid grid-cols-7 gap-3">
                        <div 
                            v-for="day in weekDays" 
                            :key="day.date"
                            class="border-2 rounded-xl overflow-hidden transition-all"
                            :class="isToday(day.fullDate) ? 'border-blue-400 bg-blue-50/50' : 'border-gray-200 hover:border-blue-300'"
                        >
                            <div class="text-center py-3 border-b-2 border-gray-200" :class="isToday(day.fullDate) ? 'bg-blue-100' : 'bg-gray-50'">
                                <div class="font-bold text-sm text-gray-900">{{ day.name }}</div>
                                <div class="text-xs font-semibold mt-1" :class="isToday(day.fullDate) ? 'text-blue-600' : 'text-gray-600'">
                                    {{ day.date }}
                                </div>
                            </div>
                            <div class="p-2 space-y-1.5 max-h-96 overflow-y-auto custom-scrollbar">
                                <button
                                    v-for="slot in day.availableSlots"
                                    :key="slot"
                                    @click="selectSlot(day.fullDate, slot)"
                                    class="w-full text-xs px-2.5 py-2 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-lg hover:from-green-600 hover:to-emerald-600 transition-all font-medium shadow-sm hover:shadow-md transform hover:scale-105"
                                >
                                    {{ slot }}
                                </button>
                                <div v-if="day.availableSlots.length === 0" class="text-xs text-gray-400 text-center py-4">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Sin espacios
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendar Grid - Mobile/Tablet -->
                <div class="lg:hidden p-4 space-y-3">
                    <div 
                        v-for="day in weekDays" 
                        :key="day.date"
                        class="border-2 rounded-xl overflow-hidden"
                        :class="isToday(day.fullDate) ? 'border-blue-400 bg-blue-50/30' : 'border-gray-200'"
                    >
                        <div class="flex items-center justify-between px-4 py-3 border-b-2 border-gray-200" :class="isToday(day.fullDate) ? 'bg-blue-100' : 'bg-gray-50'">
                            <div class="flex items-center">
                                <div class="mr-3">
                                    <div class="font-bold text-base text-gray-900">{{ day.name }}</div>
                                    <div class="text-sm font-semibold" :class="isToday(day.fullDate) ? 'text-blue-600' : 'text-gray-600'">
                                        {{ day.date }}
                                    </div>
                                </div>
                            </div>
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full" :class="day.availableSlots.length > 0 ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'">
                                {{ day.availableSlots.length }} espacios
                            </span>
                        </div>
                        <div class="p-3">
                            <div v-if="day.availableSlots.length > 0" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2">
                                <button
                                    v-for="slot in day.availableSlots"
                                    :key="slot"
                                    @click="selectSlot(day.fullDate, slot)"
                                    class="text-sm px-3 py-2.5 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-lg hover:from-green-600 hover:to-emerald-600 transition-all font-semibold shadow-sm hover:shadow-md"
                                >
                                    {{ slot }}
                                </button>
                            </div>
                            <div v-else class="text-center py-6">
                                <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <p class="text-sm text-gray-500">No hay espacios disponibles</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Modal de Confirmación de Cita -->
        <Teleport to="body">
            <Transition name="modal">
                <div v-if="showModal" class="fixed inset-0 z-[100] overflow-y-auto" @click.self="closeModal">
                    <!-- Overlay oscuro con blur -->
                    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>
                    
                    <!-- Modal Container -->
                    <div class="flex min-h-full items-center justify-center p-4">
                        <div 
                            class="modal-container relative bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all"
                            @click.stop
                        >
                            <!-- Header del Modal -->
                            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-4 rounded-t-2xl">
                                <div class="flex items-center justify-between text-white">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-9 h-9 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold">Confirmar Cita</h3>
                                    </div>
                                    <button 
                                        @click="closeModal"
                                        class="w-8 h-8 rounded-lg hover:bg-white/20 transition-colors flex items-center justify-center"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Detalles de la Cita -->
                            <div class="px-5 pt-4 pb-3">
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-3.5 space-y-2.5">
                                    <div class="flex items-start">
                                        <svg class="w-4 h-4 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <div class="flex-1">
                                            <p class="text-[11px] text-gray-600 font-medium">Médico:</p>
                                            <p class="text-sm font-bold text-gray-900">{{ doctor.name }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <svg class="w-4 h-4 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <div class="flex-1">
                                            <p class="text-[11px] text-gray-600 font-medium">Fecha y Hora:</p>
                                            <p class="text-sm font-bold text-gray-900 capitalize">{{ selectedSlot?.dateFormatted }}</p>
                                            <p class="text-base font-bold text-blue-600 mt-0.5">{{ selectedSlot?.time }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Formulario -->
                            <form @submit.prevent="submitAppointment" class="px-5 pb-5">
                                <div class="mb-3">
                                    <div class="flex items-center mb-3">
                                        <svg class="w-4 h-4 text-blue-600 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <h4 class="text-sm font-bold text-gray-900">Datos del Paciente</h4>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <div>
                                        <label for="modal_patient_name" class="block text-xs font-semibold text-gray-700 mb-1">
                                            Nombre completo *
                                        </label>
                                        <input
                                            id="modal_patient_name"
                                            v-model="appointmentForm.patient_name"
                                            type="text"
                                            required
                                            placeholder="Ingrese su nombre completo"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            :class="{ 'border-red-500 ring-2 ring-red-200': formErrors.patient_name }"
                                        />
                                        <p v-if="formErrors.patient_name" class="mt-1 text-xs text-red-600 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ formErrors.patient_name }}
                                        </p>
                                    </div>

                                    <div>
                                        <label for="modal_patient_email" class="block text-xs font-semibold text-gray-700 mb-1">
                                            Correo electrónico *
                                        </label>
                                        <input
                                            id="modal_patient_email"
                                            v-model="appointmentForm.patient_email"
                                            type="email"
                                            required
                                            placeholder="correo@ejemplo.com"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            :class="{ 'border-red-500 ring-2 ring-red-200': formErrors.patient_email }"
                                        />
                                        <p v-if="formErrors.patient_email" class="mt-1 text-xs text-red-600 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ formErrors.patient_email }}
                                        </p>
                                    </div>

                                    <div>
                                        <label for="modal_patient_phone" class="block text-xs font-semibold text-gray-700 mb-1">
                                            Teléfono <span class="text-gray-500 font-normal">(opcional)</span>
                                        </label>
                                        <input
                                            id="modal_patient_phone"
                                            v-model="appointmentForm.patient_phone"
                                            type="tel"
                                            placeholder="Ej: 300 123 4567"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        />
                                    </div>

                                    <div v-if="formErrors.start" class="p-2.5 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-red-500 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            <p class="text-xs text-red-700 font-medium">{{ formErrors.start }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botones -->
                                <div class="flex gap-2.5 mt-4">
                                    <button
                                        type="button"
                                        @click="closeModal"
                                        class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 border border-gray-300 transition-all"
                                    >
                                        Cancelar
                                    </button>
                                    <button
                                        type="submit"
                                        :disabled="isSubmitting"
                                        class="flex-1 flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg hover:from-blue-700 hover:to-indigo-700 disabled:from-gray-400 disabled:to-gray-400 disabled:cursor-not-allowed shadow-lg hover:shadow-xl transition-all"
                                    >
                                        <svg v-if="isSubmitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <svg v-else class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ isSubmitting ? 'Confirmando...' : 'Confirmar Cita' }}
                                    </button>
                                </div>

                                <!-- Info box -->
                                <div class="mt-3 p-2 bg-blue-50 rounded-lg border border-blue-100">
                                    <div class="flex items-start">
                                        <svg class="w-4 h-4 text-blue-600 mr-1.5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-[10px] text-gray-700 leading-relaxed">
                                            Recibirás un correo de confirmación con los detalles de tu cita.
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>

        <!-- Footer profesional -->
        <Footer class="relative z-10" />
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import Footer from '@/Components/Footer.vue';

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

// Estado del modal
const showModal = ref(false);
const selectedSlot = ref(null);

// Formulario de cita
const appointmentForm = ref({
    patient_name: '',
    patient_email: '',
    patient_phone: ''
});

const formErrors = ref({});
const isSubmitting = ref(false);

const selectSlot = (date, time) => {
    const [hours, minutes] = time.split(':');
    const selectedDate = new Date(date);
    selectedDate.setHours(hours, minutes, 0, 0);
    
    selectedSlot.value = {
        date: selectedDate,
        time: time,
        dateFormatted: selectedDate.toLocaleDateString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
    };
    
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    appointmentForm.value = {
        patient_name: '',
        patient_email: '',
        patient_phone: ''
    };
    formErrors.value = {};
};

const submitAppointment = async () => {
    formErrors.value = {};
    isSubmitting.value = true;
    
    try {
        await router.post('/appointments', {
            doctor_id: props.doctor.id,
            start: selectedSlot.value.date.toISOString(),
            patient_name: appointmentForm.value.patient_name,
            patient_email: appointmentForm.value.patient_email,
            patient_phone: appointmentForm.value.patient_phone
        }, {
            onSuccess: () => {
                closeModal();
            },
            onError: (errors) => {
                formErrors.value = errors;
                isSubmitting.value = false;
            }
        });
    } catch (error) {
        isSubmitting.value = false;
    }
};

const previousWeek = () => {
    currentWeekStart.value.setDate(currentWeekStart.value.getDate() - 7);
    currentWeekStart.value = new Date(currentWeekStart.value);
};

const nextWeek = () => {
    currentWeekStart.value.setDate(currentWeekStart.value.getDate() + 7);
    currentWeekStart.value = new Date(currentWeekStart.value);
};

const isToday = (date) => {
    const today = new Date();
    return date.toDateString() === today.toDateString();
};

const currentWeekRange = computed(() => {
    const start = new Date(currentWeekStart.value);
    const end = new Date(currentWeekStart.value);
    end.setDate(end.getDate() + 6);
    
    return `${start.toLocaleDateString('es-ES', { day: 'numeric', month: 'short' })} - ${end.toLocaleDateString('es-ES', { day: 'numeric', month: 'short', year: 'numeric' })}`;
});
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
