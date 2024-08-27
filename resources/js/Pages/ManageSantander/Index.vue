<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                Administración de E-Commerce Comercializadora Santander
            </h2>
        </template>

        <div class="flex justify-center mt-8 space-x-4">
            <a
                :href="route('products.index')"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg"
            >
                Administrar Productos
            </a>

            <a
                :href="route('customers.index')"
                class="px-4 py-2 bg-green-500 text-white rounded-lg"
            >
                Administrar Clientes
            </a>

            <a
                :href="route('sales.index')"
                class="px-4 py-2 bg-red-500 text-white rounded-lg"
            >
                Administrar Ventas
            </a>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

</script>
