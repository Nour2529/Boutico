<template>
 <footer
          class="text-center text-lg-start text-dark pb-5"
          style="background-color: #ECEFF1">
    <div>
    <div class = "row text-center">
        <div class = "col-sm d-flex">
            
        </div>
        
        
    </div>



    <!-- Remove the container if you want to extend the Footer to full width. -->

 
   
    <section class="">
      <div class="container text-center text-md-start mt-5">
        <div class="row mt-3">
          <!-- Grid column -->
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
            <!-- Content -->
            <h6 class="text-uppercase fw-bold">Boutico</h6>
            <hr
                class="mb-4 mt-0 d-inline-block mx-auto"
                style="width: 60px; background-color: #7c4dff; height: 2px"
                />
            <p>
              We are a company in Tunisia that sells clothes and accessories and we are proud to be the best in the country.
            </p>
          </div>
          <!-- Grid column -->

      
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold">Contact</h6>
            <hr
                class="mb-4 mt-0 d-inline-block mx-auto"
                style="width: 60px; background-color: #7c4dff; height: 2px"
                />
            <p><i class="fas fa-home mr-3"></i> Sfax, TUNISIA</p>
            <p><i class="fas fa-envelope mr-3"></i> contact@Boutico.tn</p>
          </div>
          <!-- Grid column -->
        </div>
        <!-- Grid row -->
      </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->

    <!-- Copyright -->
 
</div>
</footer>
  <!-- Footer -->

<!-- End of .container -->
</template>

<script>
import axios from 'axios';
import { ref, onMounted, computed } from 'vue';

const isAuthenticated = () => {
  const token = localStorage.getItem('token');
  return token ? true : false;
};

export default {
  setup() {
    const categories = ref([]);
    const visibleCategories = computed(() => categories.value.slice(0, 2));

    const marques = ref([]);
    const visibleMarques = computed(() => marques.value.slice(0, 2));

    const fetchCategories = () => {
      axios
        .get('http://localhost:8000/api/categories')
        .then((response) => {
          categories.value = response.data;
        })
        .catch((error) => {
          console.error(error);
        });
    };

    const fetchMarques = () => {
      axios
        .get('http://localhost:8000/api/marques')
        .then((response) => {
          marques.value = response.data;
        })
        .catch((error) => {
          console.error(error);
        });
    };

    onMounted(() => {
      fetchCategories();
      fetchMarques();
      isAuthenticated();
    });

    return {
      categories,
      visibleMarques,
      visibleCategories,
    };
  },
};
</script>