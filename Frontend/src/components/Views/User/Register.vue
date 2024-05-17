<template>
  <div class="container mt-5">
    <div class="text-center mt-2 mb-4">
      <h2>Register</h2>
    </div>
    <form @submit.prevent="register">
      <div class="mb-3">
        <span class="p-input-icon-left">
          <i class="pi pi-user" />
          <InputText
            class="mt-2"
            name="name"
            placeholder="Full Name"
            v-model="user.name"
            type="text"
          />
        </span>
      </div>

      <div class="mb-3">
        <span class="p-input-icon-left">
          <i class="pi pi-envelope" />
          <InputText
            class="mt-2"
            name="email"
            placeholder="Email"
            v-model="user.email"
            type="email"
          />
        </span>
      </div>

      <div class="mb-3">
        <span class="p-input-icon-left">
          <i class="pi pi-lock" />
          <InputText
          class="mt-2"
          name="password"
          placeholder="Password"
          v-model="user.password"
          type="password"
        />
        </span>
        
      </div>
      <div class="text-center">
        <Toast />
        <Button type="submit" label="Sign Up"  @click="handleSubmit"></Button>
      </div>
    </form>
  </div>
</template>


<script setup>
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import axios from "axios";
//import router
import { useRouter } from 'vue-router';
const router = useRouter();
import { useToast } from 'primevue/usetoast';

const toast = useToast();



const user = {
  name: "",
  email: "",
  password: "",
};

const register = () => {
  console.log(user);
  axios
    .post("http://localhost:8000/api/register", user)
    .then((response) => {
      if (user.name === "" || user.email === "" || user.password === "") {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Please fill all the fields' });
      } else {
        toast.add({ severity: 'success', summary: 'Success', detail: 'Account created successfully', life: 3000 });
        setTimeout(() => {
          router.push({ name: 'Login' });
        }, 3000);
      }
    })
    .catch((error) => {
      console.error(error);
    });
};


const handleSubmit = () => {
  register();
  
  
}

</script>

<style scoped>
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 50vh; /* Adjust the height as needed */
}
</style>