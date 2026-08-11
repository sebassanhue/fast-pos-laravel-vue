<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex h-screen bg-slate-50 font-sans text-slate-800 overflow-hidden">
        
        <!-- Menú Lateral (Sidebar) -->
        <aside class="w-20 md:w-64 bg-slate-900 text-slate-300 flex flex-col transition-all duration-300 shadow-2xl z-20">
            <div class="h-20 flex items-center justify-center md:justify-start md:px-8 border-b border-slate-800">
                <span class="text-2xl font-black text-white tracking-tighter hidden md:block">FAST<span class="text-indigo-500">POS</span></span>
                <span class="text-2xl font-black text-indigo-500 md:hidden">FP</span>
            </div>
            
            <nav class="flex-1 py-6 flex flex-col gap-2 px-3">
                <Link href="/" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-colors" :class="{ 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20': $page.url === '/' }">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                    <span class="font-medium hidden md:block">Punto de Venta</span>
                </Link>
                
                <Link href="/productos" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-colors" :class="{ 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20': $page.url.startsWith('/productos') }">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                    <span class="font-medium hidden md:block">Productos e Inventario</span>
                </Link>

                <Link href="/historial" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-colors" :class="{ 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20': $page.url.startsWith('/historial') }">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                    <span class="font-medium hidden md:block">Historial de Ventas</span>
                </Link>
            </nav>
        </aside>

        <!-- Contenido Dinámico de las Páginas -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <slot /> 
        </div>
    </div>
</template>