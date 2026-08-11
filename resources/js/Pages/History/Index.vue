<script setup>
import { Head } from '@inertiajs/vue3';
import PosLayout from '@/Layouts/PosLayout.vue';

defineProps({
    sales: Array
});
</script>

<template>
    <Head title="Historial de Ventas" />
    <PosLayout>
        <div class="p-8 h-full flex flex-col overflow-hidden bg-slate-50/50">
            <header class="mb-8">
                <h1 class="text-2xl font-bold text-slate-800">Historial de Ventas</h1>
            </header>
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex-1 overflow-auto flex flex-col">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-gray-100 sticky top-0">
                        <tr>
                            <th class="px-6 py-4">Orden</th>
                            <th class="px-6 py-4">Productos Vendidos</th>
                            <th class="px-6 py-4 text-right">Monto Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr v-if="sales.length === 0">
                            <td colspan="3" class="text-center py-10 text-slate-400">Aún no hay ventas registradas.</td>
                        </tr>
                        <tr v-for="sale in sales" :key="sale.id" class="hover:bg-slate-50/50">
                            <td class="px-6 py-4 font-semibold text-indigo-600">{{ sale.order_number }}</td>
                            <td class="px-6 py-4 text-slate-600">
                                <span v-for="(item, index) in sale.items" :key="index">
                                    {{ item.quantity }}x {{ item.name }}<span v-if="index < sale.items.length - 1">, </span>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-emerald-600 font-black text-right">${{ sale.total.toLocaleString('es-CL') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </PosLayout>
</template>