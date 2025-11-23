<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, watch, ref } from 'vue';

const page = usePage();
const showSuccess = ref(false);

// 3.2.3.1 - Capturar mensaje de éxito desde el flash message
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

const form = useForm({
    name: '',
    description: '',
    priority: 1,
    state: true, // activa por defecto
});

// 3.2.2 - Consumir endpoint store del controlador web
const submit = () => {
    console.log('📤 ENVIANDO FORMULARIO...', form.data());
    form.post(route('categories.web.store'), {
        preserveScroll: true,
        onSuccess: () => {
            console.log('✅ Categoría creada exitosamente');
            form.reset(); // Limpiar formulario después de crear
        },
        onError: (errors) => {
            console.error('❌ Errores de validación:', errors);
        }
    });
};
</script>

<template>
    <Head title="Crear categoría" />

    <!-- 🎉 Toast de éxito (3.2.3.1) -->
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
            style="position: fixed !important;"
        >
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="font-medium">{{ successMessage }}</span>
        </div>
    </Transition>

    <div class="py-6 max-w-3xl mx-auto px-4">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Crear categoría
                </h1>
                <p class="text-gray-600 mt-1">Complete el formulario para crear una nueva categoría</p>
            </div>

            <Link 
                :href="route('categories.index')" 
                class="text-blue-600 hover:text-blue-800 underline font-medium flex items-center gap-1"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al listado
            </Link>
        </div>

        <!-- 3.2.3.2 - Bloque general de errores de validación -->
        <div v-if="Object.keys(form.errors).length" class="mb-4 bg-red-100 border border-red-400 text-red-800 p-4 rounded-lg">
            <div class="flex items-start gap-2">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="font-bold mb-1">❌ Hay errores en el formulario:</p>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        <li v-for="(error, key) in form.errors" :key="key">
                            <strong>{{ key }}:</strong> {{ error }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Formulario con validaciones frontend y backend -->
        <form @submit.prevent="submit" class="space-y-5 bg-white p-6 shadow-lg rounded-lg">
            
            <!-- 3.2.1 - Campo Nombre con validación frontend -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2" for="name">
                    Nombre <span class="text-red-500">*</span>
                </label>
                <input 
                    id="name" 
                    v-model="form.name" 
                    type="text" 
                    class="w-full border rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    :class="{ 'border-red-500 bg-red-50': form.errors.name }"
                    required
                    minlength="3"
                    maxlength="100"
                    placeholder="Ingrese el nombre de la categoría"
                />
                <p class="text-xs text-gray-500 mt-1">
                    Mínimo 3 caracteres, máximo 100. Actual: {{ form.name.length }}/100
                </p>
                <!-- 3.2.3.2 - Mostrar error específico del campo -->
                <div v-if="form.errors.name" class="text-red-600 text-sm mt-2 flex items-center gap-1 bg-red-50 p-2 rounded">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ form.errors.name }}</span>
                </div>
            </div>

            <!-- 3.2.1 - Campo Descripción con validación frontend -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2" for="description">
                    Descripción
                </label>
                <textarea 
                    id="description" 
                    v-model="form.description" 
                    class="w-full border rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    :class="{ 'border-red-500 bg-red-50': form.errors.description }"
                    rows="4"
                    maxlength="255"
                    placeholder="Descripción opcional de la categoría"
                />
                <p class="text-xs text-gray-500 mt-1">
                    Máximo 255 caracteres. Actual: {{ form.description.length }}/255
                </p>
                <!-- 3.2.3.2 - Error específico del campo -->
                <div v-if="form.errors.description" class="text-red-600 text-sm mt-2 flex items-center gap-1 bg-red-50 p-2 rounded">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ form.errors.description }}</span>
                </div>
            </div>

            <!-- 3.2.1 - Campo Prioridad con validación frontend -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2" for="priority">
                    Prioridad <span class="text-red-500">*</span>
                </label>
                <input 
                    id="priority" 
                    v-model.number="form.priority" 
                    type="number" 
                    min="1"
                    class="w-full border rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    :class="{ 'border-red-500 bg-red-50': form.errors.priority }"
                    required
                    placeholder="Ejemplo: 1"
                />
                <p class="text-xs text-gray-500 mt-1">
                    Número entero mayor o igual a 1
                </p>
                <!-- 3.2.3.2 - Error específico del campo -->
                <div v-if="form.errors.priority" class="text-red-600 text-sm mt-2 flex items-center gap-1 bg-red-50 p-2 rounded">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ form.errors.priority }}</span>
                </div>
            </div>

            <!-- 3.2.1 - Campo Estado -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="flex items-center gap-3">
                    <input 
                        id="state" 
                        v-model="form.state" 
                        type="checkbox" 
                        class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer" 
                    />
                    <label for="state" class="font-semibold text-gray-700 cursor-pointer flex items-center gap-2">
                        <span>Estado:</span>
                        <span 
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold"
                            :class="form.state ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                        >
                            {{ form.state ? '✓ Activa' : '✗ Inactiva' }}
                        </span>
                    </label>
                </div>
                <!-- 3.2.3.2 - Error específico del campo -->
                <div v-if="form.errors.state" class="text-red-600 text-sm mt-2 flex items-center gap-1 bg-red-50 p-2 rounded">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ form.errors.state }}</span>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>{{ form.processing ? 'Guardando...' : 'Guardar categoría' }}</span>
                </button>

                <button 
                    type="button" 
                    class="border border-gray-300 px-6 py-3 rounded-lg hover:bg-gray-50 transition font-semibold flex items-center gap-2" 
                    @click="form.reset()"
                    :disabled="form.processing"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Limpiar
                </button>
            </div>

            <!-- Info adicional -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-800">
                <div class="flex gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <p>
                        <strong>Nota:</strong> Los campos marcados con <span class="text-red-600 font-bold">*</span> son obligatorios. 
                        Las validaciones se realizan tanto en el frontend (HTML5) como en el backend (Laravel).
                    </p>
                </div>
            </div>
        </form>
    </div>
</template>