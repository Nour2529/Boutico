<template>
    <form @submit.prevent="handleSubmit">
        <div class="card" style="width: 50rem;">
            <div class="card-body">
                <h5 class="card-title">Montant à payer : {{ amount }} TND</h5>
                <br />
                <div class="card-text">
                    <div class="form-group">
                        <InputText type="email" class="form-control" placeholder="Email" v-model="email" />
                    </div>
                    <br />
                </div>
                <div id="card-element"></div>
                <br />
                <Button type="submit" class="btn btn-success" label ="Procéder au
                    payement" />
            </div>
        </div>
    </form>
</template>
<script setup>
import { onMounted, ref } from 'vue';
import { loadStripe } from '@stripe/stripe-js';
import store from '../../../store';
import { useRouter } from 'vue-router';
import axios from "axios";
const router = useRouter();



const stripePromise =
    loadStripe('pk_test_51OYStbBeZ19mXMZySR5s5pSivF8PZYzJKuJ9qLa5Pxe8iMy7kntFGd9tu3kIZZ9V0NCFslioSXNT63OB46IN8kZZ00HMJyQDoQ');
const stripe = ref(null);
let cardElement; // Déclarer cardElement comme variable globale
let amount = ref(0);
let email = ref("");
onMounted(async () => {
    amount.value = store.state.Articlestore.cartTotal;
    stripe.value = await stripePromise;
    const elements = stripe.value.elements();
    cardElement = elements.create('card'); // Affecter cardElement
    cardElement.mount('#card-element');
    //log api key
    console.log(stripe.value._apiKey);
});

const cartId = ref();

const cart = ref({
    total_amount : store.state.Articlestore.cartTotal,
    user_id : localStorage.getItem('user_id'),
    status : 0
});

const cartItems = ref({
    quantity : 0,
    unit_price : 0,
    order_id : 0,
    product_id : 0
});

const confirmOrder = async () => {
    console.log(cart.value);
    await axios.post('http://localhost:8000/api/orders', cart.value)
    .then(response => {
        console.log(response.data);
        cartId.value = response.data.id;
    })
    .catch(error => {
        console.log(error);
    });

        store.state.Articlestore.cart.forEach(item => {
        cartItems.value.quantity = item.qty;
        cartItems.value.unit_price = item.product.price;
        cartItems.value.order_id = cartId.value;
        cartItems.value.product_id = item.product.id;
        console.log(cartItems.value);
        axios.post('http://localhost:8000/api/order-items', cartItems.value)
        .then(response => {
            console.log(response.data);
        })
        .catch(error => {
            console.log(error);
        });
        axios.post('http://localhost:8000/api/products/stock/' + `${cartItems.value.product_id}`, { stock :cartItems.value.quantity})
        .then(response => {
            console.log(response.data);
        })
        .catch(error => {
            console.log(error);
        });
    });
};


const handleSubmit = async () => {
    confirmOrder();
    const { token, error } = await stripe.value.createToken(cardElement);
    if (error) {
        console.error(error);
    } else {
        // Envoie le token au serveur pour traiter le paiement
        const response = await axios.post('http://localhost:8000/api/createpayment', {
  token: token.id,
  //api key
    api_key: stripe.value._apiKey,

  amount: amount.value * 100,
  email: email.value
}).catch(error => {
  console.error('Error:', error.response.data);
});
        if (response.data.message) {
            console.log(response.data.message);
            // Le paiement est réussi
            alert(response.data.message);
            //Vider le cart
            store.commit('Articlestore/clearCart')
            //Redirection
            router.push('/')
        } else {
            console.error(response.data.error);
        }
    }
    
};
</script>