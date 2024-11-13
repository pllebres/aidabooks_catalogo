<template>
    <div>
        <h1>Libros</h1>
        <ul>
            <li v-for="book in books" :key="book.id">{{ book.title }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            books: []
        };
    },
    mounted() {
        fetch('/api/books') // Asegúrate de que la ruta coincide con la configurada en Laravel
            .then(response => response.json())
            .then(data => {
                this.books = data;
            });
    }
};
</script>
