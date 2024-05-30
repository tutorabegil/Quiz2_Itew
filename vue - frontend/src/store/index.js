import { createStore } from 'vuex'

export default createStore({
  state: {
    products: [],
    accountDetails: [],
  },

  getters: {
    getAccountDetails(state){
      return state.accountDetails;
    },

    getProducts(state){
      return state.products;
    }
  },

  mutations: {
    loadAccountDetails(state, payload){
      state.accountDetails = payload
    },

    loadProducts(state, payload){
      state.products = payload;
    },

    addProduct(state, payload){
      state.products.push(payload);
    },

    updateProduct(state, payload){
      for(let i = 0; i < state.products.length; i++){
        if(state.products[i].name.toLowerCase() == payload.name.toLowerCase()){
          state.products[i] = payload;
        }
      }
    },

    deleteProduct(state, payload){
      for(let i = 0; i < state.products.length; i++){
        if(state.products[i].name.toLowerCase() == payload.name.toLowerCase()){
          state.products.splice(i, 1);
        }
      }
    }
  },

  actions: {
    asyncLoadAccountDetails(context, payload){
        context.commit('loadAccountDetails', payload);
    },

    asyncLoadProducts(context, payload){
      context.commit('loadProducts', payload);
    },

    asyncAddProduct(context, payload){
      context.commit('addProduct', payload);
    },

    asyncUpdateProduct(context, payload){
      context.commit('updateProduct', payload);
    },

    asyncDeleteProduct(context, payload){
      context.commit('deleteProduct', payload);
    }
  },

  modules: {
  },
})
