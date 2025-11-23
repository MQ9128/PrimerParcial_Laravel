<script setup>
import { ref, computed, watch } from 'vue';
import { Head, Link, usePage, router } from '@inertiajs/vue3';

const props = defineProps({
    categories: Object,
    filters: Object,
});

// Campo de búsqueda controlado
const search = ref(props.filters.search ?? '');

// Cuando el usuario escribe y presiona Enter o botón Buscar
const doSearch = () => {
    router.get(route('categories.index'), { search: search.value }, {
        preserveState: true,
        replace: true,
    });
};

// Acceso a los flashes (mensajes de éxito)
const page = usePage();
const showSuccess = ref(false);
const successMessage = computed(() => page.props.flash?.success);

// Mostrar toast cuando hay mensaje de éxito
watch(successMessage, (newValue) => {
    if (newValue) {
        showSuccess.value = true;
        setTimeout(() => {
            showSuccess.value = false;
        }, 3000);
    }
});

// 4.1.2 y 4.3 - Función para eliminar con confirmación
const deleteCategory = (category) => {
    if (confirm(`¿Seguro que deseas eliminar la categoría "${category.name}"?`)) {
        router.delete(route('categories.destroy', category.id), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                console.log('✅ Categoría eliminada correctamente');
            },
            onError: (errors) => {
                console.error('❌ Error al eliminar:', errors);
                alert('Error al eliminar la categoría');
            }
        });
    }
};
</script>

<template>
    <Head title="Categorías" />

    <!-- 🎉 Toast de éxito - POSICIÓN FIJA que NO afecta el layout -->
    <Transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0 translate-y-[-100%]"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 translate-y-[-100%]"
    >
        <div
            v-if="showSuccess"
            class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2 max-w-md"
            style="position: fixed !important;"
        >
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="font-medium">{{ successMessage }}</span>
        </div>
    </Transition>

    <div class="py-6 px-4 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Categorías</h1>
                <p class="text-gray-600 mt-1">Gestión de categorías de vehículos</p>
            </div>

            <div class="flex gap-3">
                <Link 
                    :href="route('dashboard')" 
                    class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </Link>

                <Link 
                    :href="route('cars.index')" 
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                    </svg>
                    Carros
                </Link>

                <Link 
                    :href="route('categories.create')" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nueva categoría
                </Link>
            </div>
        </div>

        <!-- Buscador -->
        <div class="mb-6 flex gap-3 bg-white p-4 rounded-lg shadow-sm">
            <input 
                v-model="search" 
                @keyup.enter="doSearch" 
                type="text" 
                placeholder="Buscar por nombre..."
                class="flex-1 border border-gray-300 px-4 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
            />
            <button 
                @click="doSearch" 
                class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Buscar
            </button>
        </div>

        <!-- Tabla de categorías - SIN AFECTAR POR EL TOAST -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-fixed">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="w-16 px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase">ID</th>
                            <th class="w-40 px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Nombre</th>
                            <th class="w-28 px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Estado</th>
                            <th class="w-24 px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Prioridad</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Descripción</th>
                            <th class="w-24 px-4 py-4 text-center text-xs font-semibold text-gray-700 uppercase"># Carros</th>
                            <th class="w-80 px-4 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="category in categories.data" :key="category.id" class="hover:bg-gray-50 transition">
                            <td class="px-4 py-4 text-sm text-gray-700 font-medium">
                                {{ category.id }}
                            </td>
                            <td class="px-4 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ category.name }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <span 
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold whitespace-nowrap"
                                    :class="category.state 
                                        ? 'bg-green-100 text-green-800' 
                                        : 'bg-red-100 text-red-800'"
                                >
                                    <span 
                                        class="w-1.5 h-1.5 rounded-full mr-1.5"
                                        :class="category.state ? 'bg-green-500' : 'bg-red-500'"
                                    ></span>
                                    {{ category.state ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700">
                                {{ category.priority }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                <div class="truncate" :title="category.description">
                                    {{ category.description || 'Sin descripción' }}
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex items-center justify-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-bold min-w-[2.5rem]">
                                    {{ category.cars_count }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <!-- 4.1.1 y 4.1.2 - Acciones de editar y eliminar -->
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Botón Ver -->
                                    <Link 
                                        :href="route('categories.show', category.id)" 
                                        class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-md transition text-sm font-medium whitespace-nowrap"
                                    >
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Ver
                                    </Link>
                                    
                                    <!-- Botón Editar -->
                                    <Link 
                                        :href="route('categories.edit', category.id)" 
                                        class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 rounded-md transition text-sm font-medium whitespace-nowrap"
                                    >
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </Link>
                                    
                                    <!-- Botón Eliminar -->
                                    <button
                                        @click="deleteCategory(category)"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-md transition text-sm font-medium whitespace-nowrap"
                                    >
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        <div class="mt-6 flex justify-center items-center gap-2">
            <button 
                v-for="link in categories.links" 
                :key="link.label" 
                :disabled="!link.url"
                @click="link.url && router.get(link.url, {}, { preserveState: true })" 
                class="px-4 py-2 border rounded-lg transition font-medium text-sm"
                :class="{ 
                    'bg-blue-600 text-white border-blue-600': link.active,
                    'bg-white text-gray-700 border-gray-300 hover:bg-gray-50': !link.active && link.url,
                    'opacity-50 cursor-not-allowed bg-gray-100': !link.url
                }" 
                v-html="link.label" 
            />
        </div>
    </div>
</template>