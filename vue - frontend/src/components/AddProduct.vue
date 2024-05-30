<template>
    <div>
      <NavBar></NavBar>
      <div class="splitter-container">
        <!-- Background image -->
        <div class="background-image"></div>
        <!-- Wrapper -->
        <div class="wrapper">
          <div class="text-center mt-4 name">
            Add Product
          </div>
          <form @submit.prevent="addProduct" class="p-3 mt-3">
            <div class="form-field d-flex align-items-center mb-3">
              <span class="fas fa-tag"></span>
              <input type="text" class="form-control" id="name" v-model="name" placeholder="Enter name" required>
            </div>
  
            <div class="form-field d-flex align-items-center mb-3">
              <span class="fas fa-info-circle"></span>
              <textarea class="form-control" v-model="description" id="description" rows="3" placeholder="Description" required></textarea>
            </div>
  
            <div class="form-field d-flex align-items-center mb-3">
              <span class="fas fa-dollar-sign"></span>
              <input type="number" class="form-control" step="0.01" v-model="price" placeholder="Price" required />
            </div>
  
            <div class="form-field d-flex align-items-center mb-3">
              <span class="fas fa-boxes"></span>
              <input type="number" class="form-control" v-model="stocks" placeholder="Stocks" required>
            </div>
  
            <div class="d-flex align-items-center justify-content-center">
              <button type="submit" class="btn mt-3 btn-success">Save</button>
              <router-link to="/home" class="btn mt-3 btn-secondary ml-2">Cancel</router-link>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  <script>
  import axios from '@/lib/axios';
  import NavBar from '@/components/NavBar.vue';
  export default {
    components: {
      NavBar
    },
    data() {
      return {
        name: '',
        description: '',
        price: 0.00,
        stocks: 0
      };
    },
    methods: {
      async addProduct() {
        try {
          // check if product already exists
          let products = this.$store.getters.getProducts;
          for (let i = 0; i < products.length; i++) {
            if (this.name.toLowerCase() === products[i].name.toLowerCase()) {
              throw "Product already exists";
            }
          }
          const response = await axios.post('/api/products/store', {
            name: this.name,
            description: this.description,
            stocks: this.stocks,
            user_id: this.$store.getters.getAccountDetails.id,
            price: this.price
          });
  
          if (response.status === 201) {
            this.$store.dispatch('asyncAddProduct', response.data.product);
            alert('Product created');
  
            this.$router.push('/home');
          }
        } catch (error) {
          alert(error);
        }
      }
    }
  };
  </script>
 
  
  <style scoped>
  .splitter-container {
    display: flex;
    height: 100vh;
  }
  
  .background-image {
    flex: 2;
    background-image: url('https://cdn.dribbble.com/users/934035/screenshots/2850232/media/cb5df13b3c67c98f9a16df1802686784.gif');
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
  
  .name {
    font-weight: 600;
    font-size: 1.4rem;
    letter-spacing: 1.3px;
    padding-left: 10px;
    color: #555;
  }
  
  .form-field input,
  .form-field textarea {
    width: 100%;
    display: block;
    border: none;
    outline: none;
    background: none;
    font-size: 1.2rem;
    color: #666;
    padding: 10px 15px 10px 10px;
  }
  
  .form-field {
    padding-left: 10px;
    margin-bottom: 20px;
    border-radius: 20px;
    box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;
  }
  
  .form-field .fas {
    color: #555;
  }
  
  .form-field input:focus,
  .form-field textarea:focus {
    box-shadow: none;
  }
  
  .btn {
    width: 100%;
    height: 40px;
    letter-spacing: 1.3px;
    border-radius: 25px;
    font-size: 18px;
    box-shadow: rgba(45, 35, 66, 0.5) 0 2px 4px, rgba(45, 35, 66, 0.5) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
    background-color: #4ba4a6;
    border: none;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  
  .btn-success:hover {
    background: linear-gradient(to bottom, #57bcbe, white);
    color: black;
    border: 1px solid #408d8e;
    transform: scale(1.02);
  }
  
  .btn-secondary {
    background-color: #6c757d;
  }
  
  .btn-secondary:hover {
    background-color: #5a6268;
  }
  
  @media(max-width: 768px) {
    .background-image {
      display: none;
    }
  
    .wrapper {
      padding: 20px;
    }
  }
  
  @media(max-width: 480px) {
    .name {
      font-size: 1.2rem;
    }
  
    .btn {
      font-size: 16px;
      
    }
  }
  </style>
  
