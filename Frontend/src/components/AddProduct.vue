<template>
  <div>
  <div class="centeredDiv">
    
    </div>
  <div class="add-product-page">
    <form @submit.prevent="handleSubmit" class="card" enctype="multipart/form-data">
      <h2>Add Product</h2>
      <div class="mb-3">
        <label for="part_number" class="form-label">Part Number</label>
        <br />
        <InputText type="text" id="part_number" v-model="product.part_number" />
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <br />
        <InputText
          type="text"
          id="name"
          v-model="product.name"
          class="w-full"
          required
        />
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <br />
        <TextArea id="description" v-model="product.description" />
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <br />
        <InputNumber
          type="number"
          id="price"
          mode="currency"
          currency="TND"
          v-model="product.price"
          required
        />
      </div>
      <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <br />
        <Dropdown
          v-model="product.category_id"
          :options="categories"
          optionLabel="name"
          optionValue="id"
          placeholder="Select Categories"
          class="w-full"
        />
      </div>
      <div class="mb-3">
        <label class="form-label">Brand</label>
        <br />
        <Dropdown
          v-model="product.marque_id"
          :options="marques"
          optionLabel="name"
          optionValue="id"
          placeholder="Select Brands"
          class="w-full md:w-14rem"
        />
         
      </div>
      <div class="mb-3">
        <label for="stock">Stock</label>
        <br />
        <InputNumber
          v-model="product.stock"
          inputId="stacked-buttons"
          showButtons
        />
      </div>
      <div class="mb-3">
        <Toast />
        <label for="image" class="form-label">Product Image</label>
        <input type="file" id="image" @change="handleImageUpload" class="form-control" />
      </div>
      <Button type="submit" label="Submit" />
    </form>
  </div>
</div>
</template>

<style scoped>
.add-product-page {
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

.centeredDiv {
  text-align: center;
}
</style>


<script setup>
import InputNumber from "primevue/inputnumber";
import Dropdown from "primevue/dropdown";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import TextArea from "primevue/textarea";
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRouter } from 'vue-router';
const router = useRouter();
import { useToast } from 'primevue/usetoast';



const toast = useToast();

onMounted(() => {
  getCategories();
  getMarques();
});

const categories = ref();
const marques = ref();
const product = ref({
  name: "",
  description: "",
  price: "",
  category_id: "",
  marque_id: "",
  stock: "",
  part_number: "",
  image: null
});


const handleImageUpload = async (event) => {
  const selectedFile = event.target.files[0];
  product.value.image = selectedFile;
};

const getMarques = () => {
  axios
    .get("http://localhost:8000/api/marques")
    .then((res) => {
      marques.value = res.data;
    })

    .catch((error) => {
      console.log(error);
    });
};

const getMarqueImage = (id) => {
  axios
    .get(`http://localhost:8000/api/marques/image/${id}`)
    .then((res) => {
      console.log(id);
      console.log(res.data);
      return res.data;
    })

    .catch((error) => {
      console.log(error);
    });
};

const getCategories = () => {
  axios
    .get("http://localhost:8000/api/categories")
    .then((res) => {
      categories.value = res.data;
    })

    .catch((error) => {
      console.log(error);
    });
};

const addproduct = () => {
  console.log(product);
  axios
    .post("http://localhost:8000/api/products", product.value, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    })
    .then((response) => {
      console.log(response);
      if (product.value.name === "" || product.value.description === "" || product.value.price === "" || product.value.category_id === "" || product.value.marque_id === "" || product.value.stock === "" || product.value.part_number === "" || product.value.image === null) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Please fill all the fields' });
      } else {
        toast.add({ severity: 'success', summary: 'Success', detail: 'Product added successfully', life: 3000 });
        
        //location reload after 3000
        setTimeout(() => {
          location.reload();
        }, 3000);
        
      }
     
    })
    .catch((error) => {
      console.log(error);
    });
};
const handleSubmit = () => {
  addproduct();
};
</script>