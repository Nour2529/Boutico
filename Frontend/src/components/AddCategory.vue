<template>
  <div>
   <div class="centeredDiv">
      <h2>You can add new categories here</h2>
      <p>Categories are used to classify products.</p>
    </div>
    
    <div class ="add-category-page">
        <form @submit.prevent="addcategory" class="card">
          <h2>Add Category</h2>

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <br>
                <InputText type="text" v-model="category.name" required/>
            </div>
            <Toast />
            <Button type="submit" label="Submit"/>
        </form>
    </div>
  </div>

</template>

<style scoped>
.add-category-page {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 50vh;
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

.centeredDiv {
  text-align: center;
}
</style>


<script setup>
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import axios from 'axios';
import { useRouter } from 'vue-router';
const router = useRouter();
import { useToast } from 'primevue/usetoast';

const toast = useToast();

const category = {
    name: "",
};

const addcategory = () => {
    axios
    .post("http://localhost:8000/api/categories", category)
    .then((response) => {
      if (category.name === "") {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Please fill all the fields' });
      } else {
        toast.add({ severity: 'success', summary: 'Success', detail: 'Category added successfully', life: 3000 });
        //push to /admin
        //location reload after 3000
        setTimeout(() => {
          location.reload();
        }, 3000);
      }
    })
    .catch((error) => {
      console.log(error);
    });
}
</script>