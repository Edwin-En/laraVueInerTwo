<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { defineProps, ref, onMounted, inject  } from 'vue';

const props = defineProps({
    parameters: {type:Object}
});


const formData = useForm({
    length: null,
    uppercase: null,
    lowercase: null,
    digits: null,
    special_characters: null,
});

const lengthOptions = ref(Array.from({ length: 11 }, (_, i) => i + 5));


const saveParameters = () => {

    formData.post(route('passwordParameters.store'),{
        onSuccess: () => {
            Swal.fire({title:"Parametrizacion guardada", icon:'success'});
        }
    });
};

onMounted(() => {
    if (props.parameters) {
        formData.length = props.parameters.length;
        formData.uppercase = props.parameters.uppercase;
        formData.lowercase = props.parameters.lowercase;
        formData.digits = props.parameters.digits;
        formData.special_characters = props.parameters.special_characters;
    }
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">Parámetros de Contraseña</h2>
        </template>

        <div class="py-12 d-flex justify-center">
            <div class="w-50">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="saveParameters">
                        <div class="mb-4 d-flex">
                            <label for="length" class="block text-sm font-medium text-gray-700">Longitud:</label>
                            <select v-model="formData.length" id="length" name="length" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 mt-n3 mx-4 rounded-md shadow-sm w-20">
                                <option v-for="value in lengthOptions" :key="value" :value="value">{{ value }}</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <input type="checkbox" id="uppercase" v-model="formData.uppercase" class="mr-2 rounded shadow">
                            <label for="uppercase" class="text-sm font-medium text-gray-700">Letras mayúsculas</label>
                        </div>
                        <div class="mb-4">
                            <input type="checkbox" id="lowercase" v-model="formData.lowercase" class="mr-2 rounded shadow">
                            <label for="lowercase" class="text-sm font-medium text-gray-700">Letras minúsculas</label>
                        </div>
                        <div class="mb-4">
                            <input type="checkbox" id="digits" v-model="formData.digits" class="mr-2 rounded shadow">
                            <label for="digits" class="text-sm font-medium text-gray-700">Dígitos (0-9)</label>
                        </div>
                        <div class="mb-4">
                            <input type="checkbox" id="special_characters" v-model="formData.special_characters" class="mr-2 rounded shadow">
                            <label for="special_characters" class="text-sm font-medium text-gray-700">Caracteres especiales</label>
                        </div>
                        <div class="d-flex justify-end">
                            <button type="submit" class="bg-green-500 hover:bg-white text-black shadow font-bold py-2 px-4 rounded">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>