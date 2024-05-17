
<template>
  <Menubar :model="items">
    <template #start>
      <svg
        width="35"
        height="40"
        viewBox="0 0 35 40"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        class="h-2rem"
      >
        <!-- ... (your SVG paths) ... -->
      </svg>
    </template>
    <template #item="{ item, props, hasSubmenu, root }">
      <Button
        v-ripple
        class="flex align-items-center p-button-text "
        v-bind="props.action"
        @click="navigateTo(item.route)"
      >
        <span :class="item.icon" />
        <span class="ml-2">{{ item.label }}</span>
        <Badge
          v-if="item.badge"
          :class="{ 'ml-auto': !root, 'ml-2': root }"
          :value="item.badge"
        />
        <span
          v-if="item.shortcut"
          class="ml-auto border-1 surface-border border-round surface-100 text-xs p-1"
        >
          {{ item.shortcut }}
        </span>
        <i
          v-if="hasSubmenu"
          :class="[
            'pi pi-angle-down text-primary',
            { 'pi-angle-down ml-2': root, 'pi-angle-right ml-auto': !root },
          ]"
        ></i>
      </Button>
    </template>
    <template #end>
      <div class="flex align-items-center gap-2 ml-auto">
        <!-- Sign In and Sign Up buttons with added spacing -->
        <div v-if="state.isLoggedIn === false">
          <Button
            label="Sign In"
            class="p-button-text"
            @click="signIn"
            style="margin-right: 10px"
          />
          <Button label="Sign Up" class="p-button-text" @click="signUp" />
        </div>
        <div v-else>
          <Button
            label="Log Out"
            class="p-button-text"
            severity="danger"
            @click="logout"
          />
        </div>
      </div>
    </template>
  </Menubar>
</template>



<script setup>
import Menubar from "primevue/menubar";
import "primevue/resources/themes/lara-light-green/theme.css";
import Button from "primevue/button";
import Badge from "primevue/badge";
import axios from "axios";
import store from "../store";
import { reactive, onMounted, ref, watch, watchEffect } from "vue";

const state = reactive({
  isLoggedIn: false,
  
});


watchEffect(() => {
  if (state.isLoggedIn) {
    state.isLoggedIn = localStorage.getItem("isLoggedIn");
    console.log(state.isLoggedIn);
  }
});

watch(() => store.state.Articlestore.cart.length, (newCartLength) => {
  const cartIndex = items.value.findIndex((i) => i.label === 'Cart');
  if (cartIndex !== -1) {
    items.value[cartIndex].badge = `${newCartLength}`;
  }
});


onMounted(() => {
  // Check if localStorage is available before accessing its methods
  if (typeof localStorage !== "undefined") {
    state.isLoggedIn = JSON.parse(localStorage.getItem("isLoggedIn")) === true;
  }
});

//import router
import { useRouter } from "vue-router";
const router = useRouter();

var items = ref([
  { label: "Home", icon: "pi pi-fw pi-home", route: "/" },
  { label: "Products", icon: "pi pi-fw pi-tag", route: "/listproduct" },
  { label: "Dashboard" , icon: "pi pi-fw pi-chart-bar", route: "/admin", visible : localStorage.getItem("role") === "1"},
  {
    label: "Cart",
    icon: "pi pi-fw pi-shopping-cart",
    badge: `${store.state.Articlestore.cart.length}`,
    route: "/cart",
    visible : localStorage.getItem("isLoggedIn") === "true",
  }, // Example with a badge
]);

const signIn = () => {
  router.push({ name: "Login" });
  console.log("Sign In button clicked");
};

const signUp = () => {
  router.push({ name: "Register" });
  console.log("Sign Up button clicked");
};

const logout = () => {
  let token = localStorage.getItem("token");
  axios
    .post("http://localhost:8000/api/logout", null, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })
    .then(() => {
      localStorage.removeItem("token");
      localStorage.removeItem("name");
      localStorage.removeItem("email");
      localStorage.removeItem("user_id");
      localStorage.removeItem("role");
      localStorage.setItem("isLoggedIn", false);
      store.commit("Articlestore/clearCart");
      router.push({ name: "Login" });
      
    });
  console.log("Log Out button clicked");
};

const navigateTo = (route) => {
  // navigate to route
  router.push(route);
};
</script>
