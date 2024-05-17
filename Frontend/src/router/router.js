// router.js
import { createRouter, createWebHistory } from 'vue-router';
import AddProduct from '../components/AddProduct.vue';
import Register from '../components/Views/User/Register.vue';
import Login from '../components/Views/User/Login.vue';
import AddCategory from '../components/AddCategory.vue';
import AddBrand from '../components/AddBrand.vue';
import ShowAllProduct from '../components/Views/ProductsList/ShowAllProduct.vue';
import HomeCart from '../components/Views/cart/HomeCart.vue';
import Cart from  '../components/Views/cart/Cart.vue';
import Paiement from '../components/Views/cart/Paiement.vue';
import Home from '../components/Views/Home/Home.vue';
import AdminDashboard from '../components/Views/Dashboard/AdminDashboard.vue';
import WelcomeAdmin from '../components/Views/Dashboard/WelcomeAdmin.vue';

const isAuthenticated = () => {
  const token = localStorage.getItem('token');
  console.log(token);
  if (token) {
    return true;
  } else {
    return false;
  }
};

const isAdmin = () => {
  const token = localStorage.getItem('token');
  const role = localStorage.getItem('role');
  if (token && role == 1) {
    return true;
  } else {
    return false;
  }
}

const routes = [
  { path: '/', component: Home , name:'Home'},
  
  { path: '/register', component: Register , name:'Register',meta:{isAuth:false}},
  { path: '/login', component: Login , name:'Login',},

  { path: '/listproduct', component: ShowAllProduct, name:'ShowAllProduct'},
  { path: '/homecart', component: HomeCart , name:'HomeCart',
  beforeEnter: (to, from, next) => {
    if (isAuthenticated()) {
      next();
    } else {
      next('/login');
    }
  },
},
  { path: '/cart', component: Cart, name:'Cart' , 
  beforeEnter: (to, from, next) => {
    if (isAuthenticated()) {
      next();
    } else {
      next('/login');
    }
  },
},
  { path: '/paiement', component: Paiement , name:'Paiement'},
  { 
    path: '/admin', 
    component: AdminDashboard, 
    name: 'AdminDashboard',
    beforeEnter: (to, from, next) => {
      console.log('BeforeEnter isAdmin:', isAdmin());
      if (isAdmin()) {
        next();
      } else {
        next('/login');
      }
    },
  },

];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
