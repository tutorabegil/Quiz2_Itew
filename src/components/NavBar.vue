<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-brand btn-link">
            <img :src="require('@/assets/logo-ecommerce.png')" width="30" height="30" alt="">
            LAZAPEE
        </button>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/home">Home</a>
                </li>
            </ul>
            <button @click="logout" class="btn btn-danger ml-auto custom-logout-button">Logout</button>
        </div>
    </nav>
</template>


<script>
import axios from '@/lib/axios';
export default {
    computed: {
        getAccountDetails() {
            return this.$store.getters.getAccountDetails;
        }
    },
    methods: {
        async logout() {
            try {
                const response = await axios.post('/api/logout', {
                    email: this.getAccountDetails.email
                });
                if (response.status == 200) {
                    localStorage.removeItem('token');
                    this.$store.dispatch('asyncLoadAccountDetails', []);
                    this.$store.dispatch('asyncLoadProducts', []);
                    this.$router.push('/');
                }
            } catch (error) {
                console.log(error);
            }
        }
    }
}
</script>

<style scoped>
.btn-link {
    border-color: transparent;
}
</style>
