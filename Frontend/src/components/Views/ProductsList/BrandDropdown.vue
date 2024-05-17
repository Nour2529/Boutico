<template>
  <div class="brand-dropdown">
     <div class="p-field">
       <label for="brand">Brand:</label>
       <Dropdown
         id="brand"
         v-model="selectedBrand"
         :options="brands"
         optionLabel="name"
         optionValue="id"
         placeholder="Select a Brand"
         @change="$emit('brand-selected', selectedBrand)"
       />
     </div>
     
  </div>
 </template>
 
 <script setup>
 import { ref, onMounted } from 'vue';
 import axios from 'axios';
 import Dropdown from 'primevue/dropdown';

 import 'primevue/resources/themes/saga-blue/theme.css';
 import 'primevue/resources/primevue.min.css';
 import 'primeicons/primeicons.css';
 
 const selectedBrand = ref();
 const selectedCategory = ref('');
 const brands = ref([]);
 const categories = ref([]);
 
 onMounted(() => {
  fetchBrands();
  fetchCategories();
 });
 
 const fetchBrands = () => {
  axios
     .get('http://localhost:8000/api/marques')
     .then((response) => {
       brands.value = response.data;
     })
     .catch((error) => {
       console.error(error);
     });
 };
 
 const fetchCategories = () => {
  axios
     .get('http://localhost:8000/api/categories')
     .then((response) => {
       categories.value = response.data;
     })
     .catch((error) => {
       console.error(error);
     });
 };
 </script>