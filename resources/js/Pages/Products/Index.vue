<script setup>
import { Head, useForm, router } from '@inertiajs/vue3';
import PosLayout from '@/Layouts/PosLayout.vue';
import { ref } from 'vue';

// Recibimos los productos reales desde Laravel
defineProps({
    products: Array
});

// Controla si la ventana modal está abierta o cerrada
const isModalOpen = ref(false);

// El formulario inteligente de Inertia
const form = useForm({
    name: '',
    category: '',
    price: ''
});

// Función para guardar
const saveProduct = () => {
    form.post('/productos', {
        onSuccess: () => {
            isModalOpen.value = false;
            form.reset();
        }
    });
};

// Función para eliminar
const deleteProduct = (id) => {
    if (confirm('¿Estás seguro de eliminar este producto?')) {
        router.delete(`/productos/${id}`);
    }
};
</script>

<template>
    <Head title="Gestión de Productos" />
    <PosLayout>
        <div class="p-8 h-full flex flex-col overflow-hidden bg-slate-50/50 relative">
            <header class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-slate-800">Inventario de Productos</h1>
                <!-- Botón que abre el modal -->
                <button @click="isModalOpen = true" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium shadow-sm hover:bg-indigo-700 transition-colors">
                    + Nuevo Producto
                </button>
            </header>
            
            <!-- Tabla de Productos Reales -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex-1 overflow-auto flex flex-col">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-gray-100 sticky top-0">
                        <tr>
                            <th class="px-6 py-4">Producto</th>
                            <th class="px-6 py-4">Categoría</th>
                            <th class="px-6 py-4">Precio</th>
                            <th class="px-6 py-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr v-if="products.length === 0">
                            <td colspan="4" class="text-center py-10 text-slate-400">No hay productos en el inventario.</td>
                        </tr>
                        <tr v-for="product in products" :key="product.id" class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-800">{{ product.name }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ product.category }}</td>
                            <td class="px-6 py-4 text-emerald-600 font-semibold">${{ product.price.toLocaleString('es-CL') }}</td>
                            <td class="px-6 py-4 text-center">
                                <button @click="deleteProduct(product.id)" class="text-red-500 hover:text-red-700 font-medium bg-red-50 px-3 py-1.5 rounded-lg">Quitar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- MODAL FANTASMA (Formulario) -->
            <div v-if="isModalOpen" class="absolute inset-0 bg-slate-900/40 flex items-center justify-center z-50 backdrop-blur-sm">
                <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md">
                    <h2 class="text-xl font-bold mb-6 text-slate-800">Agregar Producto</h2>
                    
                    <form @submit.prevent="saveProduct" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nombre</label>
                            <input v-model="form.name" type="text" required class="w-full border-gray-200 rounded-xl px-4 py-2 focus:ring-indigo-500" placeholder="Ej: Hamburguesa Simple">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Categoría</label>
                            <input v-model="form.category" type="text" required class="w-full border-gray-200 rounded-xl px-4 py-2 focus:ring-indigo-500" placeholder="Ej: Comida Rápida">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Precio ($)</label>
                            <input v-model="form.price" type="number" required class="w-full border-gray-200 rounded-xl px-4 py-2 focus:ring-indigo-500" placeholder="Ej: 3500">
                        </div>

                        <div class="flex gap-3 mt-8">
                            <button type="button" @click="isModalOpen = false" class="flex-1 px-4 py-2 bg-slate-100 text-slate-700 font-medium rounded-xl hover:bg-slate-200">Cancelar</button>
                            <button type="submit" :disabled="form.processing" class="flex-1 px-4 py-2 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </PosLayout>
</template>