<template>
    <Head title="Login" />
    <main class="place-items-center mt-8">
        <section class="bg-white p-8 rounded-xl max-w-md mx-auto border">
            <h1 class="text-3xl">Login</h1>

            <form @submit.prevent="submit" method="post" class="max-w-md mx-auto mt-8">
                <!-- email -->
                <div class="mb-6">
                    <label for="email" class="block mb-2 uppercase font-bold text-xs text-gray-700">
                        Email
                    </label>
                    <input v-model="form.email" type="email" name="email" id="email"
                        class="border p-2 w-full rounded" required>
                    <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-xs mt-2"></div>
                </div>
                <!-- password -->
                <div class="mb-6">
                    <label for="password" class="block mb-2 uppercase font-bold text-xs text-gray-700">
                        Password
                    </label>
                    <input v-model="form.password" type="password" name="password" id="password"
                        class="border p-2 w-full rounded" required>
                    <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-xs mt-2">
                    </div>
                </div>

                <button type="submit" class="min-w-full bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500"
                    :disabled="form.processing">
                    Log In
                </button>
            </form>
        </section>
    </main>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

defineOptions({
    layout: null,
});

let form = useForm({
    email: '',
    password: '',
});

let submit = () => {
    form.post('/login', form);
};
</script>
