<template>
    <footer class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Logo y descripción -->
                <div class="space-y-3">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Clínica Oftalmológica</h3>
                            <p class="text-xs text-gray-400">Universidad de Caldas</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Cuidamos tu salud visual con tecnología de punta y profesionales especializados.
                    </p>
                </div>

                <!-- Contacto -->
                <div>
                    <h4 class="text-sm font-bold mb-3 text-blue-400">Contacto</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>(606) 878 1500</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>contacto@oftalmo.ucaldas.edu.co</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="flex-1">Calle 65 #26-10, Manizales, Caldas</span>
                        </li>
                    </ul>
                </div>

                <!-- Horarios -->
                <div>
                    <h4 class="text-sm font-bold mb-3 text-blue-400">Horario de Atención</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li class="flex justify-between">
                            <span class="font-medium text-gray-300">Lunes - Viernes:</span>
                            <span>7:00 AM - 5:00 PM</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="font-medium text-gray-300">Sábados:</span>
                            <span>8:00 AM - 12:00 PM</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="font-medium text-gray-300">Domingos:</span>
                            <span class="text-red-400">Cerrado</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-700 mt-6 pt-6">
                <div class="flex flex-col sm:flex-row justify-between items-center text-sm text-gray-400">
                    <p>&copy; {{ new Date().getFullYear() }} Clínica Oftalmológica - Universidad de Caldas. Todos los derechos reservados.</p>
                    <div class="flex space-x-4 mt-3 sm:mt-0">
                        <a href="#" class="hover:text-blue-400 transition-colors">Política de Privacidad</a>
                        <span>•</span>
                        <a href="#" class="hover:text-blue-400 transition-colors">Términos de Uso</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
// Footer component for the ophthalmology clinic
</script>
