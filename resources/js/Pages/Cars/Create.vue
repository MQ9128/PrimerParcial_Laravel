<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, watch, ref } from 'vue';

const props = defineProps({
    categories: Array,
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

const form = useForm({
    car_make: '',
    car_model: '',
    car_year: new Date().getFullYear(),
    car_price: '',
    car_status: true,
    barcode: '',
    category_id: '',
});

const submit = () => {
    console.log('📤 ENVIANDO FORMULARIO...', form.data());
    form.post(route('cars.store'), {
        preserveScroll: true,
        onSuccess: () => {
            console.log('✅ Carro creado exitosamente');
            form.reset();
        },
        onError: (errors) => {
            console.error('❌ Errores de validación:', errors);
        }
    });
};

// Generar código automático
const generateBarcode = () => {
    const random = Math.random().toString(36).substring(2, 8).toUpperCase();
    form.barcode = `CAR-${random}`;
};
</script>

<template>
    <Head title="Crear carro" />

    <!-- Toast de éxito -->
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
                    Crear carro
                </h1>
                <p class="text-gray-600 mt-1">Complete el formulario para agregar un nuevo vehículo</p>
            </div>

            <Link 
                :href="route('cars.index')" 
                class="text-blue-600 hover:text-blue-800 underline font-medium flex items-center gap-1"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al listado
            </Link>
        </div>

        <!-- Bloque general de errores -->
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

        <form @submit.prevent="submit" class="space-y-5 bg-white p-6 shadow-lg rounded-lg">
            
            <!-- Marca -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2" for="car_make">
                    Marca <span class="text-red-500">*</span>
                </label>
                <input 
                    id="car_make" 
                    v-model="form.car_make" 
                    type="text" 
                    class="w-full border rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    :class="{ 'border-red-500 bg-red-50': form.errors.car_make }"
                    required
                    minlength="2"
                    maxlength="100"
                    placeholder="Ejemplo: Toyota"
                />
                <p class="text-xs text-gray-500 mt-1">Mínimo 2 caracteres</p>
                <div v-if="form.errors.car_make" class="text-red-600 text-sm mt-2 flex items-center gap-1 bg-red-50 p-2 rounded">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ form.errors.car_make }}</span>
                </div>
            </div>

            <!-- Modelo -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2" for="car_model">
                    Modelo <span class="text-red-500">*</span>
                </label>
                <input 
                    id="car_model" 
                    v-model="form.car_model" 
                    type="text" 
                    class="w-full border rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    :class="{ 'border-red-500 bg-red-50': form.errors.car_model }"
                    required
                    minlength="2"
                    maxlength="100"
                    placeholder="Ejemplo: Corolla"
                />
                <div v-if="form.errors.car_model" class="text-red-600 text-sm mt-2 flex items-center gap-1 bg-red-50 p-2 rounded">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ form.errors.car_model }}</span>
                </div>
            </div>

            <!-- Año -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2" for="car_year">
                    Año <span class="text-red-500">*</span>
                </label>
                <input 
                    id="car_year" 
                    v-model.number="form.car_year" 
                    type="number" 
                    :min="1900"
                    :max="new Date().getFullYear() + 1"
                    class="w-full border rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    :class="{ 'border-red-500 bg-red-50': form.errors.car_year }"
                    required
                />
                <p class="text-xs text-gray-500 mt-1">
                    Entre 1900 y {{ new Date().getFullYear() + 1 }}
                </p>
                <div v-if="form.errors.car_year" class="text-red-600 text-sm mt-2 flex items-center gap-1 bg-red-50 p-2 rounded">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ form.errors.car_year }}</span>
                </div>
            </div>

            <!-- Precio -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2" for="car_price">
                    Precio (COP) <span class="text-red-500">*</span>
                </label>
                <input 
                    id="car_price" 
                    v-model.number="form.car_price" 
                    type="number" 
                    step="0.01"
                    min="0"
                    class="w-full border rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    :class="{ 'border-red-500 bg-red-50': form.errors.car_price }"
                    required
                    placeholder="Ejemplo: 50000000"
                />
                <p class="text-xs text-gray-500 mt-1">Solo números positivos</p>
                <div v-if="form.errors.car_price" class="text-red-600 text-sm mt-2 flex items-center gap-1 bg-red-50 p-2 rounded">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ form.errors.car_price }}</span>
                </div>
            </div>

            <!-- Categoría -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2" for="category_id">
                    Categoría <span class="text-red-500">*</span>
                </label>
                <select 
                    id="category_id" 
                    v-model="form.category_id" 
                    class="w-full border rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    :class="{ 'border-red-500 bg-red-50': form.errors.category_id }"
                    required
                >
                    <option value="">Seleccione una categoría</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
                <div v-if="form.errors.category_id" class="text-red-600 text-sm mt-2 flex items-center gap-1 bg-red-50 p-2 rounded">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ form.errors.category_id }}</span>
                </div>
            </div>

            <!-- Código de barras -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2" for="barcode">
                    Código de barras <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-2">
                    <input 
                        id="barcode" 
                        v-model="form.barcode" 
                        type="text" 
                        class="flex-1 border rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        :class="{ 'border-red-500 bg-red-50': form.errors.barcode }"
                        required
                        maxlength="50"
                        placeholder="CAR-XXXXXX"
                    />
                    <button 
                        type="button"
                        @click="generateBarcode"
                        class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition"
                    >
                        Generar
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-1">Debe ser único</p>
                <div v-if="form.errors.barcode" class="text-red-600 text-sm mt-2 flex items-center gap-1 bg-red-50 p-2 rounded">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ form.errors.barcode }}</span>
                </div>
            </div>

            <!-- Estado -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="flex items-center gap-3">
                    <input 
                        id="car_status" 
                        v-model="form.car_status" 
                        type="checkbox" 
                        class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer" 
                    />
                    <label for="car_status" class="font-semibold text-gray-700 cursor-pointer flex items-center gap-2">
                        <span>Estado:</span>
                        <span 
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold"
                            :class="form.car_status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                        >
                            {{ form.car_status ? '✓ Disponible' : '✗ No disponible' }}
                        </span>
                    </label>
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
                    <span>{{ form.processing ? 'Guardando...' : 'Guardar carro' }}</span>
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
        </form>
    </div>
</template>