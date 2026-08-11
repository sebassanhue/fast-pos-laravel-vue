<script setup>
import { Head, router } from '@inertiajs/vue3';
import PosLayout from '@/Layouts/PosLayout.vue';
import { ref, computed } from 'vue';

// 1. Recibimos los productos reales desde Laravel
defineProps({
    products: Array
});

// 2. Estado del carrito de compras
const cart = ref([]);

// 3. Función para agregar al ticket
const addToCart = (product) => {
    const existingItem = cart.value.find(item => item.id === product.id);
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.value.push({ ...product, quantity: 1 });
    }
};

// 4. Función para quitar del ticket
const removeFromCart = (index) => {
    cart.value.splice(index, 1);
};

// 5. Cálculo automático del Total
const total = computed(() => {
    return cart.value.reduce((sum, item) => sum + (item.price * item.quantity), 0);
});

// 6. Procesar la venta
const processPayment = () => {
    // Evitamos enviar si está vacío
    if (cart.value.length === 0) return;

    router.post('/ventas', {
        items: cart.value,
        total: total.value
    }, {
        onSuccess: () => {
            cart.value = []; // Vaciamos el carrito al tener éxito
            alert('¡Venta procesada correctamente!');
        }
    });
};
</script>

<template>
    <Head title="Caja Registradora" />
    <PosLayout>
        <div class="flex flex-1 h-full">
            
            <!-- SECCIÓN IZQUIERDA: Menú de Productos -->
            <main class="w-2/3 p-8 flex flex-col h-full overflow-hidden bg-slate-50/50">
                <header class="flex justify-between items-center mb-8">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">Menú Principal</h1>
                    </div>
                    <input type="text" placeholder="Buscar..." class="px-5 py-2.5 rounded-xl border-none shadow-sm focus:ring-2 focus:ring-indigo-500 bg-white w-64">
                </header>
                
                <div class="flex-1 overflow-y-auto pr-2">
                    <div class="grid grid-cols-3 gap-5">
                        <button 
                            v-for="product in products" 
                            :key="product.id"
                            @click="addToCart(product)"
                            class="bg-white p-5 rounded-2xl shadow-sm border border-transparent hover:border-indigo-500 hover:shadow-md transition-all text-left flex flex-col h-36 justify-between group active:scale-95"
                        >
                            <span class="font-bold text-slate-700 group-hover:text-indigo-600">{{ product.name }}</span>
                            <span class="font-black text-xl text-emerald-600">${{ product.price.toLocaleString('es-CL') }}</span>
                        </button>
                    </div>
                </div>
            </main>

            <!-- SECCIÓN DERECHA: Ticket -->
            <aside class="w-1/3 bg-white shadow-[-10px_0_30px_-15px_rgba(0,0,0,0.1)] flex flex-col h-full z-10 border-l border-gray-100">
                <div class="p-6 border-b border-gray-100 bg-white">
                    <h2 class="text-xl font-bold flex justify-between items-center text-slate-800">
                        Orden Actual
                        <span class="text-sm font-semibold bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full">#POS</span>
                    </h2>
                </div>
                
                <div class="flex-1 p-6 overflow-y-auto bg-slate-50/50">
                    <div v-if="cart.length === 0" class="text-center text-slate-400 mt-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-3 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        <p class="text-sm font-medium">No hay productos en el ticket</p>
                    </div>

                    <div v-else class="space-y-3">
                        <div v-for="(item, index) in cart" :key="index" class="flex justify-between items-center bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                            <div class="flex items-center gap-3">
                                <span class="bg-indigo-100 text-indigo-700 font-bold px-2 py-1 rounded text-sm">{{ item.quantity }}x</span>
                                <div>
                                    <p class="font-bold text-slate-700 text-sm">{{ item.name }}</p>
                                    <p class="text-xs text-slate-400">${{ item.price.toLocaleString('es-CL') }} c/u</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="font-black text-emerald-600 text-sm">${{ (item.price * item.quantity).toLocaleString('es-CL') }}</span>
                                <button @click="removeFromCart(index)" class="text-red-400 hover:text-red-600 bg-red-50 p-1.5 rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-white border-t border-gray-100">
                    <div class="flex justify-between text-2xl font-black text-slate-800 mb-6">
                        <span>Total</span>
                        <span class="text-indigo-600">${{ total.toLocaleString('es-CL') }}</span>
                    </div>
                    <!-- El botón ahora ejecuta processPayment -->
                    <button 
                        @click="processPayment"
                        :disabled="cart.length === 0"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 disabled:bg-slate-300 disabled:cursor-not-allowed text-white font-bold py-4 rounded-xl transition-transform active:scale-95 shadow-lg shadow-indigo-600/30 disabled:shadow-none"
                    >
                        Procesar Pago
                    </button>
                </div>
            </aside>
        </div>
    </PosLayout>
</template>