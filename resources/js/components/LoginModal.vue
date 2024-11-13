<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg w-96 shadow-lg">
            <h2 class="text-2xl font-semibold mb-4">Log In</h2>
            <form @submit.prevent="submitLogin">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" v-model="email" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" v-model="password" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Log In</button>
                    <button type="button" @click="$emit('close')" class="px-4 py-2 ml-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: '',
            password: ''
        };
    },
    methods: {
        submitLogin() {
            // Handle login logic
            console.log('Login submitted:', this.email, this.password);
            this.$emit('close');
        }
    }
};
</script>
