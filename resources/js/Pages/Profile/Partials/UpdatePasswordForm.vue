<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { watchEffect, onMounted } from 'vue';
import Swal from 'sweetalert2';

const props = defineProps({
    parametersPassword: {
        type: Object,
    }
});

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    const password = form.password;

    const { length, uppercase, lowercase, digits, special_characters } = props.parametersPassword;

    const uppercaseRegex = /[A-Z]/;
    const lowercaseRegex = /[a-z]/;
    const digitsRegex = /\d/;
    const specialCharsRegex = /[^A-Za-z0-9\.]/;

    let errorMessage = '';

    if (password.length != length) {
        errorMessage = `<br>* Debe ser de ${length} caracteres.`;
    }

    if (uppercase && !uppercaseRegex.test(password)) {
        errorMessage += '<br>* Debe contener al menos una letra mayúscula.';
    }

    if (lowercase && !lowercaseRegex.test(password)) {
        errorMessage += '<br>* Debe contener al menos una letra minúscula.';
    }

    if (digits && !digitsRegex.test(password)) {
        errorMessage += '<br>* Debe contener al menos un dígito.';
    }

    if (special_characters && !specialCharsRegex.test(password)) {
        errorMessage += '<br>* Debe contener al menos un caracter especial.';
    }

    if (errorMessage) {
        Swal.fire({title:"Parametros contraseña", icon:'warning', html: errorMessage});
    } else {
        Swal.fire({title:"Contraseña actualiza", icon:'succes'});
    }
};

const passwordStrengthClass = ref('');
const passwordText = ref('');

const passwordConfirmationStrengthClass = ref('');
const passwordConfirmationText = ref('');

const checkPasswordStrength = (password) => {
    const containsUpperCase = /[A-Z]/.test(password);
    const containsLowerCase = /[a-z]/.test(password);
    const containsDigits = /\d/.test(password);
    const containsSpecialChars = /[^A-Za-z0-9]/.test(password);

    let strength = 0;
    if (containsUpperCase) strength++;
    if (containsLowerCase) strength++;
    if (containsDigits) strength++;
    if (containsSpecialChars) strength++;

    if (strength === 0) {
        passwordStrengthClass.value = '';
    } else if (strength === 1 || strength === 2) {
        passwordStrengthClass.value = 'weak';
        passwordText.value = 'poco segura';
    } else if (strength === 3) {
        passwordStrengthClass.value = 'strong';
        passwordText.value = 'segura';
    } else {
        passwordStrengthClass.value = 'very-strong';
        passwordText.value = 'muy segura';
    }
};

const checkPasswordConfirmationStrength = (password) => {
    const containsUpperCase = /[A-Z]/.test(password);
    const containsLowerCase = /[a-z]/.test(password);
    const containsDigits = /\d/.test(password);
    const containsSpecialChars = /[^A-Za-z0-9]/.test(password);

    let strength = 0;
    if (containsUpperCase) strength++;
    if (containsLowerCase) strength++;
    if (containsDigits) strength++;
    if (containsSpecialChars) strength++;

    if (strength === 0) {
        passwordConfirmationStrengthClass.value = '';
    } else if (strength === 1 || strength === 2) {
        passwordConfirmationStrengthClass.value = 'weak';
        passwordConfirmationText.value = 'poco segura';
    } else if (strength === 3) {
        passwordConfirmationStrengthClass.value = 'strong';
        passwordConfirmationText.value = 'segura';
    } else {
        passwordConfirmationStrengthClass.value = 'very-strong';
        passwordConfirmationText.value = 'muy segura';
    }
};

watchEffect(() => {
    checkPasswordStrength(form.password);
    checkPasswordConfirmationStrength(form.password_confirmation);
});

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Update Password</h2>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div>
                <InputLabel for="current_password" value="Current Password" />

                <TextInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="current-password"
                />

                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>

            <div>
                <InputLabel for="password" value="New Password" />

                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password" class="mt-2" />

                <div class="password-strength-bar"  v-if="passwordStrengthClass">
                    <div :class="passwordStrengthClass">
                        <div>
                            Tu contraseña es {{ passwordText }}
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password_confirmation" class="mt-2" />

                <div class="password-strength-bar" v-if="passwordConfirmationStrengthClass">
                    <div :class="passwordConfirmationStrengthClass">
                        <div>
                            Tu contraseña es {{ passwordConfirmationText }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

<style scoped>
.password-strength-bar {
  margin-top: 10px;
  height: 25px;
  background-color: #f0f0f0;
  border-radius: 5px;
}

.password-strength-bar > div {
  height: 100%;
  border-radius: 5px;
  transition: width 0.3s ease;
}

.weak {
  background-color: #ff8080;
}

.strong {
  background-color: #ffd480;
}

.very-strong {
  background-color: #80ff80;
}
</style>