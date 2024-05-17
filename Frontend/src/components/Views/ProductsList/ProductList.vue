<template>
  <div class="product-list">
    <div class="product-row" v-for="(product) in products" :key="product.id">
      <Card class="product-card" style="width: 250px; height: 400px; border-radius: 5%; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <template v-slot:title>
          <div class="card-title">
            <img :src="'http://localhost:8000/images/' +  product.image" alt="Product Image" class="card-image">
            <hr style="border-top: 1px solid #ddd; margin: 10px 0;">
            <h3 class="card-name">{{ product.name }}</h3>
          </div>
        </template>
        <template v-slot:content>
          <div class="card-content">
            <div class="ellipsis card-description">{{ product.description }}</div>
            <p class="card-price">Price: {{ product.price }}</p>
          </div>
        </template>
        <template v-slot:footer>
          <div class="card-footer">
            <Toast />
            <Button label="Add To Cart" @click="addToCart(product)" class="add-to-cart-button" />
          </div>
        </template>
      </Card>
    </div>
  </div>
</template>

<style scoped>
.product-list {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  padding: 10px;
  text-align: center;
  background-color: #f8f9fa; 
}
.product-row {
  margin: 10px;
  align-items: center;
}

.product-card {
  overflow: hidden;
}

.card-title {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.card-image {
  width: 70%;
  height: 100px;
  object-fit: fit;
}

.card-name {
  margin: 10px 0;
  height: 50px;
}

.card-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  height: 80px;
}

.card-description {
  height: 40px;
  overflow: hidden;
  text-overflow: ellipsis;
}

.card-price {
  margin-top: 2px;
}

.card-footer {
  
  align-items: center;
  padding: 2px;
}
</style>

  
  <script setup>
  import { ref, onMounted, watch } from 'vue';
  import axios from 'axios';
  import store from '../../../store';
  import Card from 'primevue/card';
  import 'primeicons/primeicons.css'
  import Button from 'primevue/button';
  import { useToast } from 'primevue/usetoast';


  
  const props = defineProps(['brand']);


  watch(() => props.brand, () => {
    fetchProductsByMarque(props.brand);
  });
  const toast = useToast();

  
  const products = ref([]);
  
  onMounted(() => {
    console.log(localStorage.getItem('name'));
    console.log(localStorage.getItem('email'));
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

const fetchProductsByMarque = (id) => {
  axios
    .get(`http://localhost:8000/api/products/`)
    .then((response) => {
      products.value = response.data.filter((product) => product.marque_id === id);
      console.log(products.value); // Log the products array
    })
    .catch((error) => {
      console.error(error);
    });
}


const addToCart = (prod) => {
    store.commit("Articlestore/addCart", { product: prod, qty: 1 });
    toast.add({ severity: 'success', summary: 'Panier', detail: 'Article : ' +`${prod.name}` +" "+`${prod.part_number}` + ' Ajouté au Panier', life: 3000 });
}


  </script>
  