<template>
    <div>
      <NavBar></NavBar>
      <div class="container-lg d-flex flex-column">
        <br>
        <div class="m-2">
          <router-link to="/add" class="btn btn-primary">Add Product</router-link>
        </div>
        <h1>Welcome {{ this.getAccountDetails.name }}</h1>
  
        <div v-if="getProducts.length < 1">
          <h3>Seems empty here!</h3>
        </div>
        <div class="d-flex align-items-center justify-content-center flex-column" v-else>
  
          <h1>My Products</h1>
  
          <div class="table-responsive-sm container-fluid">
            <table class="table table-hover table-bordered">
              <thead class="">
                <th class="p-2">Name</th>
                <th class="p-2">Description</th>
                <th class="p-2">Price</th>
                <th class="p-2">Stocks</th>
                <th class="p-2">Action</th>
              </thead>
              <tbody class="">
                <tr v-for="product in this.getProducts" :key="product.name" :class="{ 'fade-out': product.deleted }">
                  <td>{{ product.name }}</td>
                  <td>{{ product.description }}</td>
                  <td>{{ product.price }}</td>
                  <td>{{ product.stocks }}</td>
                  <td>
                    <div class="d-flex align-items-center justify-content-center">
                      <button @click="gotoEdit(product.id)" class="m-2 btn btn-warning">Edit</button>
                      <form @submit.prevent="deleteProduct(product)" method="POST">
                        <button type="submit" class="btn btn-danger"
                          onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                      </form>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
  
        </div>
  
      </div>
  
      <router-view />
    </div>
  </template>
  
  <script>
  import axios from '@/lib/axios';
  import NavBar from '@/components/NavBar.vue';
  export default {
    components: {
      NavBar
    },
  
    async beforeMount() {
      // load user details
      const accountDetails = await axios.get('/api/user');
      this.$store.dispatch('asyncLoadAccountDetails', accountDetails.data)
  
      // load products of logged in user
      const products = await axios.get('/api/all', {
        params: {
          user_id: this.$store.getters.getAccountDetails.id
        }
      });
      this.$store.dispatch('asyncLoadProducts', products.data.products);
    },
  
    computed: {
      getAccountDetails() {
        return this.$store.getters.getAccountDetails;
      },
  
      getProducts() {
        return this.$store.getters.getProducts;
      }
    },
  
    methods: {
      gotoEdit(productId) {
        this.$router.push({
          name: 'editProduct',
          params: { id: productId }
        });
      },
  
      async deleteProduct(product) {
        try {
          const response = await axios.delete('/api/products/delete/' + product.id);
          if (response.status == 200) {
            // Add fade-out animation to the table row
            product.deleted = true;
  
            // assign product as payload for deletion in products list
            let payload = product;
            this.$store.dispatch('asyncDeleteProduct', payload);
  
            setTimeout(() => {
              alert("Product " + product.name + " is deleted");
            }, 500); // Delay alert to allow time for animation
  
          }
        } catch (error) {
          console.log(error)
        }
      }
    }
  }
  </script>
  
  <style scoped>
  .splitter-container {
    display: flex;
    height: 100vh;
  }
  
  .background-image {
    flex: 2;
    background-image: url('https://cdn.dribbble.com/users/443127/screenshots/11049996/media/65f8cf2ec85940bc6de1b70e80900725.gif');
    background-size: cover;
    background-position: center;
  }
  
  .wrapper {
    flex: 1;
    padding: 40px 30px 30px 30px;
    background-color: #ecf0f3;
    border-radius: 15px;
    box-shadow: 13px 13px 20px #cbced1;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  
  .fade-out {
    animation: fadeOut 0.5s ease forwards;
    transform: translateX(100%);
  }
  
  @keyframes fadeOut {
    from {
      opacity: 1;
    }
    to {
      opacity: 0;
    }
  }
  </style>
  
