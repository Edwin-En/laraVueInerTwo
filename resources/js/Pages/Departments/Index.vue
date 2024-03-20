<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Swal from 'sweetalert2';

import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    departments: {type:Object}
});

const form = useForm({
    id: '',
});

const deleteDepartment = (id, name) => {
    const alerta = Swal.mixin({
        buttonsStyling:true
    });

    alerta.fire({
        title:'¿Esta seguro de eliminar ' + name + '?',
        icon: 'question',
        showCancelButton: 'true',
        confirmButtonText: '<i class="fa-solid fa-check"></i> Si, Eliminar',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar',
    }).then((result) => {
        if(result.isConfirmed) {
            form.delete(route('departments.destroy', id));
        }
    });
}
</script>

<template>
    <Head title="Departamentos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Departamentos</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="m-3 flex">
                    <Link :href="route('departments.create')"
                            :class="'px-4 py-2 bg-gray-800 text-white border rounded-md'">
                        <i class="fa-solid fa-plus-circle"></i> Crear
                    </Link>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-4">#</th>
                            <th class="p-4">DEPARTAMENTO</th>
                            <th class="p-4"></th>
                            <th class="p-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="department, i in departments" :key="department.id">
                            <td class="border border-gray-400 p-4">{{ (i+1) }}</td>
                            <td class="border border-gray-400 p-4">{{ department.name }}</td>
                            <td class="border border-gray-400 p-4">
                                <Link :href="route('departments.edit', department.id)"
                                        :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md'">
                                    <i class="fa-solid fa-edit"></i>
                                </Link>
                            </td>
                            <td class="border border-gray-400 p-4">
                                <DangerButton @click="deleteDepartment(department.id, department.name)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>

                            </td>

                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
