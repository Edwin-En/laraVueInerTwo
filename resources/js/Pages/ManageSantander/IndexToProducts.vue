<script setup>
// Importa los componentes necesarios
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

import Swal from 'sweetalert2';
import { ref, reactive, nextTick, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    products: Object,
});

const modal = ref(false);
const title = ref('');
const operation = ref(1); // 1 = Crear, 2 = Editar
const currentProductId = ref(null);

const form = useForm({
    codigo: '',
    descripcion: '',
    stock: 0,
    precio_unitario: 0.0,
});

const openModal = (op, product) => {
    modal.value = true;
    nextTick(() => {
        // Foco en el primer campo del formulario
    });
    operation.value = op;
    if (op === 1) {
        title.value = 'Crear Producto';
        form.reset();
    } else {
        title.value = 'Editar Producto';
        form.codigo = product.codigo;
        form.descripcion = product.descripcion;
        form.stock = product.stock;
        form.precio_unitario = product.precio_unitario;
        currentProductId.value = product.codigo;
    }
};

const closeModal = () => {
    modal.value = false;
    form.reset();
};

// Función para guardar los cambios (crear o editar producto)
const save = () => {
    if (operation.value === 1) {
        form.post(route('products.store'), {
            onSuccess: () => { 
                Swal.fire('Producto creado', '', 'success');
                closeModal();
                fetchProducts();
            }
        });
    } else {
        form.put(route('products.update', currentProductId.value), {
            onSuccess: () => { 
                Swal.fire('Producto actualizado', '', 'success');
                closeModal();
                fetchProducts();
            }
        });
    }
};

// Función para eliminar un producto
const deleteProduct = (id, codigo) => {
    Swal.fire({
        title: `¿Estás seguro de eliminar el producto con código ${codigo}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('products.destroy', id), {
                onSuccess: () => {
                    Swal.fire('Producto eliminado', '', 'success');
                    fetchProducts();
                }
            });
        }
    });
};

// Función para obtener los productos
const fetchProducts = () => {
    fetch(route('products.index'))
        .then(response => response.json())
        .then(data => {
            debugger;
            props.products = data;
        });
};

// Llama a fetchProducts cuando el componente se monte
onMounted(() => {
    fetchProducts();
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Productos</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="m-3 flex">
                    <PrimaryButton @click="openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i> Crear Producto
                    </PrimaryButton>
                </div>
            </div>

            <div class="bg-white grid v-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2">Código</th>
                            <th class="p-2">Descripción</th>
                            <th class="p-2">Stock</th>
                            <th class="p-2">Precio Unitario</th>
                            <th class="p-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in props.products" :key="product.id">
                            <td class="border border-gray-400 p-2">{{ product.codigo }}</td>
                            <td class="border border-gray-400 p-2">{{ product.descripcion }}</td>
                            <td class="border border-gray-400 p-2">{{ product.stock }}</td>
                            <td class="border border-gray-400 p-2">{{ product.precio_unitario }}</td>
                            <td class="border border-gray-400 p-2">
                                <PrimaryButton @click="openModal(2, product)">
                                    <i class="fa-solid fa-edit"></i>
                                </PrimaryButton>
                                <DangerButton @click="deleteProduct(product.id, product.codigo)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal para crear/editar productos -->
        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font-medium">{{ title }}</h2>
            <div class="p-3">
                <InputLabel for="codigo" value="Código:"></InputLabel>
                <TextInput id="codigo" v-model="form.codigo" class="mt-1 block w-full" />
                <InputError :message="form.errors.codigo" class="mt-2" />
            </div>

            <div class="p-3">
                <InputLabel for="descripcion" value="Descripción:"></InputLabel>
                <TextInput id="descripcion" v-model="form.descripcion" class="mt-1 block w-full" />
                <InputError :message="form.errors.descripcion" class="mt-2" />
            </div>

            <div class="p-3">
                <InputLabel for="stock" value="Stock:"></InputLabel>
                <TextInput id="stock" type="number" v-model="form.stock" class="mt-1 block w-full" />
                <InputError :message="form.errors.stock" class="mt-2" />
            </div>

            <div class="p-3">
                <InputLabel for="precio_unitario" value="Precio Unitario:"></InputLabel>
                <TextInput id="precio_unitario" type="number" step="0.01" v-model="form.precio_unitario" class="mt-1 block w-full" />
                <InputError :message="form.errors.precio_unitario" class="mt-2" />
            </div>

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
