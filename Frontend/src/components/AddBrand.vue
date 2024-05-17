<template>
  <div class="add-brand-page">
    <form @submit.prevent="addBrand" class="card" enctype="multipart/form-data">
      <h2>Add Brand</h2>

      <div class="mb-3">
        <label for="name" class="form-label">Brand Name</label>
        <InputText id="name" v-model="brand.name" class="form-control" required/>
      </div>

      <div class="mb-3">
        <label for="image" class="form-label">Brand Image</label>
        <input type="file" id="image" @change="handleImageUpload" class="form-control" />
      </div>
      <Toast />
      <Button type="submit" label="Submit" />
    </form>
  </div>
</template>

<style scoped>
.add-brand-page {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.card {
  width: 400px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  padding: 20px;
  text-align: center;
}

.form-field {
  margin-bottom: 20px;
}
</style>

<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import InputText  from 'primevue/inputtext';
import Button  from 'primevue/button';
import FileUpload  from 'primevue/fileupload';
import { useRouter } from 'vue-router';
const router = useRouter();
import { useToast } from 'primevue/usetoast';

const toast = useToast();



onMounted(() => {
  
});

const brand = ref({
  image: null,
  name: "",
});

const handleImageUpload = async (event) => {
  const selectedFile = event.target.files[0];
  brand.value.image = selectedFile;
};

const addBrand = () => {
  const formData = new FormData();
  formData.append("name", brand.value.name);
  formData.append("image", brand.value.image);
  console.log(brand.value);
  axios.post("http://localhost:8000/api/marques", brand.value , {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    })
    .then((response) => {
      if (brand.value.name === "" || brand.value.image === null) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Please fill all the fields' });
      } else {
        toast.add({ severity: 'success', summary: 'Success', detail: 'Brand added successfully', life: 3000 });
       //location reload after 3000
       setTimeout(() => {
          location.reload();
        }, 3000);
      }
    })
    .catch((error) => {
      console.error(error);
      // Handle error
    });
};


</script>