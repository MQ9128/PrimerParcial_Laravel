<script setup>
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    car: Object,
});

// Formatear precio
const formatPrice = (price) => {
    return new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0
    }).format(price);
};
</script>

<template>
    <Head :title="`Carro: ${car.car_make} ${car.car_model}`" />

    <div class="py-6 max-w-5xl mx-auto px-4">
        <!-- Header con botones -->
        <div class="mb-6 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    Detalle del Vehículo
                </h1>
                <p class="text-gray-600">
                    Información completa del carro
                </p>
            </div>

            <div class="flex gap-2">
                <Link 
                    :href="route('cars.edit', car.id)" 
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar
                </Link>

                <Link 
                    :href="route('cars.index')" 
                    class="border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg transition flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver
                </Link>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Tarjeta principal del carro -->
            <div class="lg:col-span-2 bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-3xl font-bold text-white">{{ car.car_make }}</h2>
                            <p class="text-blue-100 text-xl mt-1">{{ car.car_model }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-blue-100 text-sm">Año</p>
                            <p class="text-3xl font-bold text-white">{{ car.car_year }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- ID -->
                        <div class="flex items-start gap-3">
                            <div class="bg-blue-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">ID</p>
                                <p class="text-lg font-semibold text-gray-800">{{ car.id }}</p>
                            </div>
                        </div>

                        <!-- Precio -->
                        <div class="flex items-start gap-3">
                            <div class="bg-green-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Precio</p>
                                <p class="text-2xl font-bold text-green-600">{{ formatPrice(car.car_price) }}</p>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="flex items-start gap-3">
                            <div class="bg-blue-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Estado</p>
                                <span 
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold mt-1"
                                    :class="car.car_status 
                                        ? 'bg-green-100 text-green-800' 
                                        : 'bg-gray-100 text-gray-800'"
                                >
                                    <span 
                                        class="w-2 h-2 rounded-full mr-2"
                                        :class="car.car_status ? 'bg-green-500' : 'bg-gray-500'"
                                    ></span>
                                    {{ car.car_status ? 'Disponible' : 'No disponible' }}
                                </span>
                            </div>
                        </div>

                        <!-- Código de barras -->
                        <div class="flex items-start gap-3">
                            <div class="bg-blue-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Código de barras</p>
                                <p class="text-lg font-mono font-semibold text-gray-800">{{ car.barcode }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de la categoría -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden h-fit">
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Categoría
                    </h3>
                </div>

                <div class="p-6">
                    <div class="text-center mb-4">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full mb-3">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-800 mb-2">{{ car.category.name }}</h4>
                        <p class="text-gray-600 text-sm mb-4">{{ car.category.description || 'Sin descripción' }}</p>
                    </div>

                    <div class="space-y-3 border-t pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Prioridad</span>
                            <span class="font-semibold text-gray-800">{{ car.category.priority }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Estado</span>
                            <span 
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold"
                                :class="car.category.state 
                                    ? 'bg-green-100 text-green-800' 
                                    : 'bg-red-100 text-red-800'"
                            >
                                {{ car.category.state ? 'Activa' : 'Inactiva' }}
                            </span>
                        </div>
                    </div>

                    <Link 
                        :href="route('categories.show', car.category.id)" 
                        class="mt-4 w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver categoría completa
                    </Link>
                </div>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex gap-3">
                <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm text-blue-800">
                        <strong>Información del sistema:</strong> Este vehículo está registrado en el sistema con ID #{{ car.id }}. 
                        Pertenece a la categoría "{{ car.category.name }}" y su código único es {{ car.barcode }}.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>