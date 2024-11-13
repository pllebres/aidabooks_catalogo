<template>
    <div class="relative">
        <button @click="toggleDropdown">Toggle Menu</button>
        <div v-if="isOpen" class="dropdown-content">
            <p>Dropdown Content</p>
            <a href="#">Option 1</a>
            <a href="#">Option 2</a>
            <a href="#">Option 3</a>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    setup() {
        const isOpen = ref(false);
        const toggleDropdown = () => {
            isOpen.value = !isOpen.value;
        };

        return {
            isOpen,
            toggleDropdown,
        };
    },
};
</script>

<style scoped>
.dropdown-content {
    padding: 10px;
    background-color: #f3f3f3;
    border: 1px solid #ccc;
    margin-top: 5px;
}
</style>

