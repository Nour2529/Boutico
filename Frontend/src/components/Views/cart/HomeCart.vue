<template>
    <div class="drag">
    <div v-if="isLoading">
    
    <h2> Loading .... </h2>
    </div>
    <div v-else class="row">
    
   
    
    <div class="product-list">
    <div class="product-row" v-for="product in Articles" :key="product.id">
      <Card class="product-card" style="width: 350px; height: 500px; border-radius: 5%; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <template v-slot:title>
          <img src=""
 alt="Product Image" style="width: 100%; height: 150px; object-fit: cover;">
          <hr style="border-top: 1px solid #ddd; margin: 10px 0;">
          <h3>{{ product.name }}</h3>
        </template>
        <template v-slot:content>
          <div class="ellipsis" style="height: 120px;">{{ product.description }}</div>
          <p>Price: {{ product.price }}</p>
        </template>
        <template v-slot:footer>
          <Button label="Add To Cart" @click="addToCart(product)"/>
        </template>
      </Card>
    </div>
  </div>
    </div>
    </div>
    
    </template>
    <script setup>
    import axios from "axios"
    import store from '../../../store'
    import { ref, onMounted } from 'vue';
    import Card from 'primevue/card';
    import 'primeicons/primeicons.css'
    import Button from 'primevue/button';
    import InputText from 'primevue/inputtext';
    
    const Articles = ref([]);
    const isLoading=ref(true)


    onMounted(() => {
         fetchProducts();
        });


  const fetchProducts = () => {
 // try catch with axios
    axios
      .get("http://localhost:8000/api/products")
      .then((response) => {
        console.log(response.data);
        Articles.value = response.data;
        isLoading.value=false
      })
      .catch((error) => {
        console.log(error);
      });
    };

    
    const addToCart=(prod)=> {
        console.log("Added");
    store.commit("Articlestore/addCart", {product:prod,qty:1});
    //console.log added
    
    
    }
    
    </script>
    <style scoped>
  

    </style>