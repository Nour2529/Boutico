<template>
  <div class = "mx-5">
  <div class="mt-3">
    <h2 class="text-center">Top Seller Products</h2>
  </div>
  <div class="card mt-3" style = "border-style: none">
    <Carousel
      :value="products"
      :numVisible="3"
      :numScroll="3"
      circular
      :autoplayInterval="2000"
    >
      <template #item="slotProps">
        <div
          class="border-1 surface-border border-round m-2 text-center py-5 px-3"
        >
          <div class="mb-3">
            <img
              :src="'http://localhost:8000/images/' + slotProps.data.image"
              :alt="slotProps.data.name"
              class="w-6 shadow-2"
              style="width: 150px; height: 150px"
            />
          </div>
          <div>
            <p class = "mb-1"> {{ slotProps.data.part_number }}</p>
            <h4 class="mb-1">{{ slotProps.data.name }}</h4>
            <p class="mb-2">{{ slotProps.data.description }}</p>
            <h6 class="mt-0 mb-3">{{ slotProps.data.price }} TND</h6>
            <Tag
              :value="slotProps.data.stock"
              :severity="getSeverity(slotProps.data.stock)"
            />
            <div
              class="mt-5 flex align-items-center justify-content-center gap-"
            >
            </div>
          </div>
        </div>
      </template>
    </Carousel>
  </div>

</div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import Carousel from "primevue/carousel";
import Button from "primevue/button";
import Tag from "primevue/tag";
import Dropdown from "primevue/dropdown";
import axios from "axios";

onMounted(() => {
  getProducts();
  getMarques();
});

const products = ref();
const marques = ref();
const selectedMarque = ref();

const getMarques = () => {
  axios
    .get("http://localhost:8000/api/marques")
    .then((res) => {
      marques.value = res.data;
      console.log(marques.value);
    })
    .catch((error) => {
      console.error(error);
    });
};

const getProducts = () => {
  axios
    .get("http://localhost:8000/api/products")
    .then((response) => {
      products.value = response.data;
      console.log(products.value); // Log the products array
    })
    .catch((error) => {
      console.error(error);
    });
};

const responsiveOptions = ref([
  {
    breakpoint: "1400px",
    numVisible: 2,
    numScroll: 1,
  },
  {
    breakpoint: "1199px",
    numVisible: 3,
    numScroll: 1,
  },
  {
    breakpoint: "767px",
    numVisible: 2,
    numScroll: 1,
  },
  {
    breakpoint: "575px",
    numVisible: 1,
    numScroll: 1,
  },
]);

const getSeverity = (status) => {
  switch (status) {
    case "INSTOCK":
      return "success";

    case "LOWSTOCK":
      return "warning";

    case "OUTOFSTOCK":
      return "danger";

    default:
      return null;
  }
};
</script>