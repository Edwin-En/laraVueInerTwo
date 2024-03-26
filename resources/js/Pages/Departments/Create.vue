<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
});

const props = defineProps({
    cities: {type:Object}
});


</script>




<template>
    <Head title="Crear Departamento" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Departamento</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="$event => form.post(route('departments.store'))"
                        class="mt-6 space-y-6 max-w-xl">
                        <InputLabel for="name" value="Department"></InputLabel>
                        <TextInput id="name" v-model="form.name" autofocus required
                        type="text"
                        class="mt-1 block w-full"></TextInput>
                        <!-- Aqui añadir select de ciudades -->
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">Ciudad</label>
                            <select id="city" v-model="form.city_id" class="mt-1 block w-full">
                                <option value="">Selecciona una ciudad</option>
                                <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                            </select>
                        </div>
                        <InputError :message="form.errors.name" class="mt-2"></InputError>
                        <PrimaryButton :disabled="form.processing">
                            <i class="fa-solid fa-save"></i> Guardar
                        </PrimaryButton>

                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
