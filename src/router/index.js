import { createRouter, createWebHistory } from 'vue-router'
import LoginPage from '@/components/LoginPage.vue'
import ProductsListPage from '@/components/ProductsListPage.vue'
import AddProduct from '@/components/AddProduct.vue';
import EditProduct from '@/components/EditProduct.vue';
import RegisterUserPage from '@/components/RegisterUserPage.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: LoginPage
  },
  {
    path: '/register',
    name: 'registerUserPage',
    component: RegisterUserPage
  },
  {
    path: '/home',
    name: 'allProducts',
    beforeEnter: (to, from, next) => {
      if(localStorage.getItem('token')){
        next();
      } else {
        next('/');
      }
    },
    component: ProductsListPage
  },
  {
    path: '/add',
    name: 'addProduct',
    beforeEnter: (to, from, next) => {
      if(localStorage.getItem('token')){
        next();
      } else {
        next('/');
      }
    },
    component: AddProduct
  },
  {
    path: '/edit/:id',
    name: 'editProduct',
    beforeEnter: (to, from, next) => {
      if(localStorage.getItem('token')){
        next();
      } else {
        next('/');
      }
    },
    component: EditProduct
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
