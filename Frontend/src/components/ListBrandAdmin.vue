<template>
    <div>
      <h2>List of Brands</h2>
  
      <DataTable :value="manufactures" :paginator="true" :rows="10" :rowsPerPageOptions="[5, 10, 20]">
        <Column field="id" header="ID"></Column>
        <Column field="name" header="Name"></Column>
        <!-- Add more columns as per your manufacture data structure -->
  
        <!-- You can customize the columns and add more as per your manufacture data structure -->
      </DataTable>
    </div>
  </template>

<script setup >

import axios from 'axios';
    import { ref, onMounted } from 'vue';
    import DataTable from 'primevue/datatable';
    import Column from 'primevue/column';
    import { useRouter } from 'vue-router';
    const router = useRouter();

    const manufactures = ref([]);

    onMounted(() => {
      fetchManufactures();
    });

    const fetchManufactures = () => {
    axios
      .get('http://localhost:8000/api/marques')
      .then((response) => {
        manufactures.value = response.data;
        console.log(manufactures.value); 
      })
      .catch((error) => {
        console.error(error);
      });
    };

</script>