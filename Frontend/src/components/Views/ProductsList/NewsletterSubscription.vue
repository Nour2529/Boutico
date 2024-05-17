<template>
    <div class="newsletter-subscription">
      <h2>Subscribe to Our Newsletter</h2>
      <form @submit.prevent="subscribeNewsletter" class="subscription-form">
        <div class="p-field">
          <label for="email">Email:</label>
          <InputText v-model="email" id="email" required />
        </div>
        <Button label="Subscribe" class="p-mr-2" @click="subscribeNewsletter" />
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import Button  from 'primevue/button';
  import InputText from 'primevue/inputtext';
  
  const email = ref('');
  
  const subscribeNewsletter = () => {
    console.log('Subscribed with email:', email.value);
   
    email.value = '';
  };
  </script>
  
  <style scoped>
  .newsletter-subscription {
    width: 100%;
    background-color: #f8f9fa;
    padding: 50px;
    text-align: center;
    height: 30vh;
  }
  
  .subscription-form {
    max-width: 400px;
    margin: 0 auto;
    height: 30vh;
  }
  
  .p-field {
    margin-bottom: 10px;
  }
  </style>
  