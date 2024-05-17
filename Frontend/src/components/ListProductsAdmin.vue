<template>
    <div>
      <h2>List of Products</h2>
  
      <DataTable :value="products" :paginator="true" :rows="10" :rowsPerPageOptions="[5, 10, 20]">
        <Column field="id" header="ID"></Column>
        <Column field="name" header="Name"></Column>
        <Column field="price" header="Price"></Column>
        <!-- Add more columns as per your product data structure -->
  
        <!-- You can customize the columns and add more as per your product data structure -->
      </DataTable>
    </div>
  </template>

    <script setup>
    import axios from 'axios';
    import { ref, onMounted } from 'vue';
    import DataTable from 'primevue/datatable';
    import Column from 'primevue/column';
    import { useRouter } from 'vue-router';
    const router = useRouter();

    const products = ref([]);

    onMounted(() => {
      fetchProducts();
    });

    const fetchProducts = () => {
    axios
      .get('http://localhost:8000/api/products')
      .then((response) => {
        products.value = response.data;
        console.log(products.value); // Log the products array
      })
      .catch((error) => {
        console.error(error);
      });
    };
    </script>
