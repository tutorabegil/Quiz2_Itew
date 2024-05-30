<template>
  <div>
    <NavBar></NavBar>
    <div class="splitter-container">
      <!-- Background image -->
      <div class="background-image"></div>
      <!-- Content -->
      <div class="wrapper">
        <h1>Edit Product</h1>
        <form @submit.prevent="updateProduct">
          <div class="d-flex flex-column container">
            <label for="name">Name</label>
            <div class="form-group mb-2">
              <input type="text" class="form-control form-control-lg" name="name" v-model="name" placeholder="Name" id="name">
            </div>

            <div class="form-group mb-2">
              <label for="description">Description</label>
              <textarea class="form-control form-control-lg" name="description" id="description" v-model="description" cols="30" rows="10"></textarea>
            </div>

            <div class="form-group mb-2">
              <label for="price">Price</label>
              <input type="number" step="0.01" class="form-control form-control-lg" name="price" v-model="price" placeholder="Price" id="price" />
            </div>

            <div class="form-group mb-2">
              <label for="stocks">Stocks</label>
              <input type="number" class="form-control form-control-lg" name="stocks" v-model="stocks" placeholder="Stocks" id="stocks">
            </div>

            <div class="d-flex align-items-center justify-content-center">
              <button type="submit" class="btn btn-success m-2">Edit</button>
              <router-link to="/home" class="btn btn-secondary">Cancel</router-link>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Error Modal -->
    <div v-if="showErrorModal" class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="modal-header">
          </div>
          <div class="modal-body">
            <p>{{ errorMessage }}</p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" @click="closeErrorModal">Close</button>
          </div>
        </div>
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
      stocks: 0,
      originalProduct: {},
      errorMessage: '',
      showErrorModal: false
    }
  },

  async beforeMount() {
    try {
      const response = await axios.get('/api/show/' + this.$route.params.id);
      let data = response.data.product;
      if (response.status == 200) {
        this.name = data.name;
        this.description = data.description;
        this.price = data.price;
        this.stocks = data.stocks;
        this.originalProduct = { ...data };
      }
    } catch (error) {
      console.log(error);
    }
  },

  methods: {
    back() {
      this.$router.go(-1);
    },

    async updateProduct() {
      try {
        // Check if any field has changed
        if (this.name === this.originalProduct.name &&
            this.description === this.originalProduct.description &&
            this.price === this.originalProduct.price &&
            this.stocks === this.originalProduct.stocks) {
          this.errorMessage = 'No changes made to the product, please change or update.';
          this.showErrorModal = true;
          return;
        }
        let payload = {
          name: this.name,
          description: this.description,
          price: this.price,
          stocks: this.stocks,
          id: this.$route.params.id
        }
        let count = 0;
        for (let i = 0; i < this.$store.getters.getProducts.length; i++) {
          if (this.$store.getters.getProducts[i].name.toLowerCase() === payload.name.toLowerCase()) {
            count++;
          }
        }

        if (count > 1) {
          throw new Error("Product name already exists");
        }

        const response = await axios.put('/api/products/update/' + this.$route.params.id, {
          name: this.name,
          description: this.description,
          price: this.price,
          stocks: this.stocks
        });

        if (response.status == 200) {
          this.$store.dispatch('asyncUpdateProduct', payload);
          this.name = '';
          this.description = '';
          this.price = 0.00;
          this.stocks = 0;
          alert('Product updated');
          this.$router.go(-1);
        }
      } catch (error) {
        this.errorMessage = error.message || 'An error occurred';
        this.showErrorModal = true;
      }
    },

    closeErrorModal() {
      this.showErrorModal = false;
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

textarea {
  height: 120px; /* Adjust the height as needed */
  resize: none; /* Prevent resizing by user */
}

/* Modal styles */
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-wrapper {
  width: 300px;
  background: white;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  border-radius: 8px;
}

.modal-container {
  padding: 20px;
}

.modal-header {
  font-weight: bold;
  font-size: 18px;
  margin-bottom: 10px;
}

.modal-body {
  margin-bottom: 20px;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
}

.modal-footer .btn {
  margin-left: 10px;
}
</style>
