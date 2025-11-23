<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, watch, ref } from 'vue';

const props = defineProps({
    category: Object,
});

const page = usePage();
const showSuccess = ref(false);

// Capturar mensaje de éxito desde el flash message
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

// 4.2 Formulario prellenado con datos de la categoría
const form = useForm({
    name: props.category.name,
    description: props.category.description,
    priority: props.category.priority,
    state: props.category.state,
});

const submit = () => {
    // 4.2 Consumir endpoint update del controlador web
    form.put(route('categories.update', props.category.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Editar categoría" />

    <!-- 🎉 Toast de éxito -->
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
            class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2"
        >
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="font-medium">{{ successMessage }}</span>
        </div>
    </Transition>

    <div class="py-6 max-w-3xl mx-auto px-4">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Editar categoría
                </h1>
                <p class="text-gray-600 mt-1">
                    Modificando: <span class="font-semibold">{{ category.name }}</span>
                </p>
            </div>

            <Link 
                :href="route('categories.index')" 
                class="text-blue-600 hover:text-blue-800 underline font-medium"
            >
                Volver al listado
            </Link>
        </div>

        <!-- 🔴 Bloque general de errores -->
        <div v-if="Object.keys(form.errors).length" class="mb-4 bg-red-100 border border-red-400 text-red-800 p-4 rounded-lg">
            <div class="flex items-start gap-2">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="font-bold mb-1">Hay errores en el formulario:</p>
                    <ul class="list-disc list-inside text-sm">
                        <li v-for="(error, key) in form.errors" :key="key">
                            {{ error }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <form @submit.prevent="submit" class="space-y-5 bg-white p-6 shadow-lg rounded-lg">
            <!-- Nombre -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2" for="name">
                    Nombre <span class="text-red-500">*</span>
                </label>
                <input 
                    id="name" 
                    v-model="form.name" 
                    type="text" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                    minlength="3"
                    maxlength="100"
                    placeholder="Ingrese el nombre"
                />
                <div v-if="form.errors.name" class="text-red-600 text-sm mt-1 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ form.errors.name }}
                </div>
            </div>

            <!-- Descripción -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2" for="description">
                    Descripción
                </label>
                <textarea 
                    id="description" 
                    v-model="form.description" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    rows="4"
                    maxlength="255"
                    placeholder="Descripción opcional"
                />
                <p class="text-xs text-gray-500 mt-1">
                    {{ form.description?.length || 0 }}/255 caracteres
                </p>
                <div v-if="form.errors.description" class="text-red-600 text-sm mt-1 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ form.errors.description }}
                </div>
            </div>

            <!-- Prioridad -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2" for="priority">
                    Prioridad <span class="text-red-500">*</span>
                </label>
                <input 
                    id="priority" 
                    v-model.number="form.priority" 
                    type="number" 
                    min="1"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                    placeholder="Ejemplo: 1"
                />
                <p class="text-xs text-gray-500 mt-1">
                    Número entero mayor o igual a 1
                </p>
                <div v-if="form.errors.priority" class="text-red-600 text-sm mt-1 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ form.errors.priority }}
                </div>
            </div>

            <!-- Estado -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="flex items-center gap-3">
                    <input 
                        id="state" 
                        v-model="form.state" 
                        type="checkbox" 
                        class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer" 
                    />
                    <label for="state" class="font-semibold text-gray-700 cursor-pointer">
                        Estado: {{ form.state ? 'Activa' : 'Inactiva' }}
                    </label>
                </div>
                <div v-if="form.errors.state" class="text-red-600 text-sm mt-2 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ form.errors.state }}
                </div>
            </div>

            <!-- Botones -->
            <div class="flex gap-3 pt-4 border-t">
                <button 
                    type="submit" 
                    class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition font-semibold flex items-center justify-center gap-2"
                    :disabled="form.processing"
                >
                    <svg v-if="form.processing" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ form.processing ? 'Actualizando...' : 'Actualizar categoría' }}</span>
                </button>

                <button 
                    type="button" 
                    class="border border-gray-300 px-6 py-3 rounded-lg hover:bg-gray-50 transition font-semibold" 
                    @click="form.reset()"
                >
                    Restablecer
                </button>
            </div>
        </form>
    </div>
</template>