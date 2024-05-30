<template>
  <div>
    <div class="splitter-container">
      <!-- Background image -->
      <div class="background-image"></div>
      <!-- Wrapper -->
      <div class="wrapper">
        <div class="logo">
          <img :src="require('@/assets/logo-ecommerce.png')" alt="E-commerce Logo" class="imglog">
        </div>
        <div class="text-center mt-4 name">
          Login
        </div>
        <form @submit.prevent="login" class="p-3 mt-3">
          <div class="form-field d-flex align-items-center mb-3">
            <span class="far fa-user"></span>
            <input type="text" name="email" v-model="email" class="form-control" placeholder="Email" required>
          </div>
          <div class="form-field d-flex align-items-center mb-3">
            <span class="fas fa-key"></span>
            <input type="password" name="password" v-model="password" class="form-control" placeholder="Password" required>
          </div>
          <button type="submit" class="btn mt-3">Login</button>
        </form>
        <div class="text-center fs-6">
          <p class="mt-3">Don't have an account? <router-link to="/register" class="link-sign">Sign up here!</router-link></p>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import axios from "@/lib/axios";

export default {
  data() {
    return {
      email: '',
      password: ''
      
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('/api/login', {
          email: this.email,
          password: this.password
        });

        if (response.status === 200) {
          localStorage.setItem('token', response.data.token);
          this.email = '';
          this.password = '';

          this.$router.push('/home');
        }
      } catch (error) {
        console.log(error);
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
  background-image: url('https://assets.materialup.com/uploads/6102cce0-dc3c-42a3-ba0e-84d25f8a7cd3/preview.gif');
  background-size: cover;
  background-position: center;
  overflow: hidden;
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

.wrapper .logo {
  width: 100px;
  margin: auto;
}

.wrapper .logo img {
  width: 120%;
  height: 120px;
  object-fit: cover;
  border-radius: 50%;
  box-shadow: 0px 0px 3px #5f5f5f,
    0px 0px 0px 5px #ecf0f3,
    8px 8px 15px #a7aaa7,
    -8px -8px 15px #fff;
}

.wrapper .name {
  font-weight: 600;
  font-size: 1.4rem;
  letter-spacing: 1.3px;
  padding-left: 10px;
  color: #555;
}

.wrapper .form-field input {
  width: 100%;
  display: block;
  border: none;
  outline: none;
  background: none;
  font-size: 1.2rem;
  color: #666;
  padding: 10px 15px 10px 10px;
}

.wrapper .form-field {
  padding-left: 10px;
  margin-bottom: 20px;
  border-radius: 20px;
  box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;
}

.wrapper .form-field .fas {
  color: #555;
}

.wrapper .form-field input:focus {
  box-shadow: none;
}

.wrapper .btn {
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

.wrapper .btn:hover {
  background: linear-gradient(to bottom, #57bcbe, white);
  color: black;
  border: 1px solid #408d8e;
  transform: scale(1.02);
  border-radius: 5rem;
}

.wrapper a {
  text-decoration: none;
  font-size: 0.8rem;font-size: 1rem;
  color: rgb(5, 99, 193); 
       }

.wrapper a:hover {
  text-decoration: underline;
  transform: scale(1.1); 
  color:  #039BE5;
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
  .wrapper .logo img {
    width: 120px;
    height: 120px;
  }

  .wrapper .name {
    font-size: 1.2rem; 
  }

  .wrapper .btn {
    font-size: 16px;
  }
}
</style>
