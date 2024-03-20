<script setup>

// Import section allow have more components conects

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Swal from 'sweetalert2';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import VueTailwindPagination from '@ocrv/vue-tailwind-pagination';

import { Head, useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';


// Declare of variables or constants

const nameInput = ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({
    employees: {type:Object},
    departments: {type:Object}
});

const form = useForm({
    name: '', email: '', phone: '', department_id: '', costo: '',
});

const formPage = useForm({});

const onPageClick = (event)=>{
    formPage.get(route('employees.index', {page:event}));
}

const openModal = (op, name, email, phone, department, employee) => {
    modal.value = true;
    nextTick( () => nameInput.value.focus());
    operation.value = op;
    id.value = employee;
    if(op == 1){
        title.value = "Crear Empleado";
    } else {
        title.value = "Editar Empleado";
        form.name = name;
        form.email = email;
        form.phone = phone;
        form.department_id = department_id;
    }
}

const closeModal = () => {
    modal.value = false;
    form.reset();
}

const save = () => {

    /*
    var maximoCosto = 150000;
    var costoCalculado = 0;
    var newCostoCalculado = 0;
    let msj = '';

    */
    if (operation.value == 1) {
        form.costo = 5000;
        form.post(route('employees.store'),{
            onSuccess: () => {ok('Empleado creado')}
        });
    } else {
        /*
        costoCalculado = maximoCosto - form.costo;
        newCostoCalculado = form.costo;
        while (newCostoCalculado != 0) {
            if (newCostoCalculado > 50000) {
                msj += " 1 Billete de 50.000";
                newCostoCalculado = newCostoCalculado - 50000;
            } if (newCostoCalculado < 50000 && newCostoCalculado >= 20000) {
                msj += " 1 Billete de 20.000";
                newCostoCalculado = newCostoCalculado - 20000;
            } if (newCostoCalculado < 20000 && newCostoCalculado >= 10000) {
                msj += " 1 Billete de 10.000";
                newCostoCalculado = newCostoCalculado - 10000;
            } if (newCostoCalculado < 10000 && newCostoCalculado >= 5000) {
                msj += " 1 Billete de 5.000";
                newCostoCalculado = newCostoCalculado - 5000;
            }if (newCostoCalculado < 5000 && newCostoCalculado >= 2000) {
                msj += " 1 Billete de 2.000";
                newCostoCalculado = newCostoCalculado - 2000;
            }if (newCostoCalculado < 2000 && newCostoCalculado >= 1000) {
                msj += " 1 Billete de 1.000";
                newCostoCalculado = newCostoCalculado - 1000;
            }
        }
        console.log(msj);

        */
       form.costo = 5000;

       form.put(route('employees.update', id.value), {
           onSuccess: () => {ok("Empleado actualizado")}
       });
    }
}

const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({title:msj, icon:'success'});
}

const deleteEmployee = (id, name) => {
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
            form.delete(route('employees.destroy', id), {
                onSuccess: () => {ok('Empleado eliminado')}
            });
        }
    });
}
</script>

<template>
    <Head title="Empleados" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Empleados</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="m-3 flex">
                    <PrimaryButton @click="$event => openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i> Crear Cliente
                    </PrimaryButton>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2">#</th>
                            <th class="p-2">NOMBRE</th>
                            <th class="p-2">Email</th>
                            <th class="p-2">Celular</th>
                            <th class="p-2">Departamento</th>
                            <th class="p-2"></th>
                            <th class="p-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="emp, i in employees.data" :key="emp.id">
                            <td class="border border-gray-400 p-2">{{ (i+1) }}</td>
                            <td class="border border-gray-400 p-2">{{ emp.name }}</td>
                            <td class="border border-gray-400 p-2">{{ emp.email }}</td>
                            <td class="border border-gray-400 p-2">{{ emp.phone }}</td>
                            <td class="border border-gray-400 p-2">{{ emp.department }}</td>
                            <td class="border border-gray-400 p-2">
                                <WarningButton
                                    @click="$event  => openModal(2, emp.name, emp.email, emp.phone, emp.department_id, emp.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 p-4">
                                <DangerButton @click="deleteEmployee(emp.id, emp.name)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>

                            </td>

                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="bg-white grid v-screen place-items-center">
                <VueTailwindPagination
                    :current="employees.currentPage" :total="employees.total"
                    :per-page="employees.perPage"
                    @page-changed="$event => onPageClick($event)">
                </VueTailwindPagination>

            </div>
        </div>
        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium">{{ title }}</h2>
            <div class="p-3 mt-6">
                <InputLabel for="name" value="Name:"></InputLabel>
                <TextInput id="name" ref="nameInput"
                v-model="form.name" type="text" class="mt-1 block w-3/4"
                placeholder="Name"></TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>

            <div class="p-3">
                <InputLabel for="email" value="Email:"></InputLabel>
                <TextInput id="email"
                v-model="form.email" type="text" class="mt-1 block w-3/4"
                placeholder="Email"></TextInput>
                <InputError :message="form.errors.email" class="mt-2"></InputError>
            </div>

            <div class="p-3">
                <InputLabel for="phone" value="Phone:"></InputLabel>
                <TextInput id="phone"
                v-model="form.phone" type="text" class="mt-1 block w-3/4"
                placeholder="Phone"></TextInput>
                <InputError :message="form.errors.phone" class="mt-2"></InputError>
            </div>

            <div class="p-3">
                <InputLabel for="department_id" value="Departamento:"></InputLabel>
                <SelectInput id="department_id" :options="departments"
                v-model="form.department_id" type="text" class="mt-1 block w-3/4"
                placeholder="Phone"></SelectInput>
                <InputError :message="form.errors.phone" class="mt-2"></InputError>
            </div>
<!--
            <div class="p-3 mt-6">
                <InputLabel for="costo" value="Total a retirar:"></InputLabel>
                <TextInput id="costo" ref="costInput"
                v-model="form.costo" type="number" class="mt-1 block w-3/4"
                placeholder="Retiro:"></TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>
-->
            <div class="p-3 mt-6">
                <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i> Guardar
                </PrimaryButton>
            </div>

            <div class="p-3 mt-6 flex justify-end">
                <SecondaryButton :disabled="form.processing" @click="closeModal">
                    Cancelar
                </SecondaryButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
