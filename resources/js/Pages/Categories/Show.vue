<script setup>
import { Head, Link } from '@inertiajs/vue3';

// 5.1 y 5.2 - Vista de detalle con registros relacionados usando load/with
const props = defineProps({
    category: Object,
});
</script>

<template>
    <Head :title="`Categoría: ${category.name}`" />

    <div class="py-6 max-w-7xl mx-auto px-4">
        <!-- Header con botones -->
        <div class="mb-6 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    Detalle de Categoría
                </h1>
                <p class="text-gray-600">
                    Información completa y carros asociados
                </p>
            </div>

            <div class="flex gap-2">
                <Link 
                    :href="route('categories.edit', category.id)" 
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar
                </Link>

                <Link 
                    :href="route('categories.index')" 
                    class="border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg transition flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver
                </Link>
            </div>
        </div>

        <!-- Tarjeta de información de la categoría -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">{{ category.name }}</h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- ID -->
                    <div class="flex items-start gap-3">
                        <div class="bg-blue-100 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">ID</p>
                            <p class="text-lg font-semibold text-gray-800">{{ category.id }}</p>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="flex items-start gap-3">
                        <div class="bg-blue-100 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Estado</p>
                            <span 
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold mt-1"
                                :class="category.state 
                                    ? 'bg-green-100 text-green-800' 
                                    : 'bg-red-100 text-red-800'"
                            >
                                <span 
                                    class="w-2 h-2 rounded-full mr-2"
                                    :class="category.state ? 'bg-green-500' : 'bg-red-500'"
                                ></span>
                                {{ category.state ? 'Activa' : 'Inactiva' }}
                            </span>
                        </div>
                    </div>

                    <!-- Prioridad -->
                    <div class="flex items-start gap-3">
                        <div class="bg-blue-100 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Prioridad</p>
                            <p class="text-lg font-semibold text-gray-800">{{ category.priority }}</p>
                        </div>
                    </div>

                    <!-- Cantidad de carros -->
                    <div class="flex items-start gap-3">
                        <div class="bg-blue-100 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Carros Asociados</p>
                            <p class="text-lg font-semibold text-gray-800">
                                {{ category.cars?.length || 0 }} 
                                {{ category.cars?.length === 1 ? 'carro' : 'carros' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex items-start gap-3">
                        <div class="bg-blue-100 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500 font-medium mb-1">Descripción</p>
                            <p class="text-gray-700 leading-relaxed">
                                {{ category.description || 'Sin descripción' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5.3 - Listado de carros asociados -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                    </svg>
                    Carros Asociados
                </h2>
                <span class="bg-white text-gray-800 px-3 py-1 rounded-full text-sm font-bold">
                    {{ category.cars?.length || 0 }}
                </span>
            </div>

            <div class="p-6">
                <!-- Si no hay carros -->
                <div v-if="!category.cars || category.cars.length === 0" class="text-center py-12">
                    <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No hay carros asociados</h3>
                    <p class="text-gray-500">Esta categoría aún no tiene carros registrados.</p>
                </div>

                <!-- Tabla de carros -->
                <div v-else class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b-2 border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Marca</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Modelo</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Año</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Precio</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Estado</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Código</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="car in category.cars" :key="car.id" class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-gray-700 font-medium">{{ car.id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 font-semibold">{{ car.car_make }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ car.car_model }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ car.car_year }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-green-600">
                                    ${{ Number(car.car_price).toLocaleString('es-CO', { minimumFractionDigits: 2 }) }}
                                </td>
                                <td class="px-4 py-3">
                                    <span 
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold"
                                        :class="car.car_status 
                                            ? 'bg-green-100 text-green-800' 
                                            : 'bg-gray-100 text-gray-800'"
                                    >
                                        {{ car.car_status ? 'Disponible' : 'No disponible' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 font-mono">{{ car.barcode }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>