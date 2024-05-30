<template>
     <div class="splitter-container">
    <div class="background-image"></div>
    <div class="wrapper">
      <div class="logo">
        <img :src="require('@/assets/logo-ecommerce.png')" alt="E-commerce Logo" class="imglog">
      </div>
      <div class="text-center mt-4 name">
        User Registration
      </div>
      <form @submit.prevent="registerUser" class="p-3 mt-3">
        <div class="form-field d-flex align-items-center">
          <span class="far fa-user"></span>
          <input type="text" name="name" v-model="name" class="form-control" placeholder="Name">
        </div>
        <div class="form-field d-flex align-items-center">
          <span class="far fa-envelope"></span>
          <input type="email" name="email" v-model="email" class="form-control" placeholder="Email">
        </div>
        <div class="form-field d-flex align-items-center">
          <span class="fas fa-key"></span>
          <input type="password" name="password" v-model="password" class="form-control" placeholder="Password">
        </div>
        <div class="form-field d-flex align-items-center">
          <span class="fas fa-key"></span>
          <input type="password" name="password_confirmation" v-model="password_confirmation" class="form-control" placeholder="Confirm Password">
        </div>
        <button type="submit" class="btn mt-3">Register</button>
      </form>
      <div class="text-center fs-6">
          <p class="mt-3">Already have an account? <router-link to="/" class="link-sign">Login here!</router-link></p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from '@/lib/axios';
  
  export default {
    data() {
      return {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      };
    },
    methods: {
      async registerUser() {
        try {
          const response = await axios.post('/api/create', {
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation,
          });
  
          if (response.status === 201) {
            // Reset fields
            this.name = '';
            this.email = '';
            this.password = '';
            this.password_confirmation = '';
            alert('New account created.');
            this.$router.go(-1);
          }
        } catch (error) {
          console.log(error);
          alert('Registration failed. Please try again.');
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
  background-image: url('https://i.pinimg.com/originals/b7/d6/8c/b7d68cdf1b8af238860fba71514eda5a.gif');
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
    width: 100%;
    padding-left: 10px;
    margin-bottom: 20px;
    border-radius: 20px;
    box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;
  }
  
  .wrapper .form-field .fas,
  .wrapper .form-field .far {
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
  .wrapper a:hover {
    color: #039BE5;
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

  @media(max-width: 380px) {
    .wrapper {
      margin: 30px 20px;
    }
  }

  .wrapper .name {
    font-size: 1.2rem; 
  }

  .wrapper .btn {
    font-size: 16px; 
  }
}
 
  </style>
  