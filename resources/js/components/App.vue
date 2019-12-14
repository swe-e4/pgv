<template>
    <div>
        <!-- Navbar -->
        <Navbar :user="user"></Navbar>

        <!-- Main -->
        <main>

            <!-- Sidebar -->
            <Sidebar></Sidebar>

            <!-- Content -->
            <router-view class="content"></router-view>
            
        </main>
    </div>
</template>

<script>
    import Navbar from './Navbar';
    import Sidebar from './Sidebar';

    export default {
        name: "App",

        components: {
            Navbar,
            Sidebar
        },

        props: [
            'user'
        ],

        mounted() {
            window.user = this.user;
            window.axios.interceptors.request.use(
                (config) => {
                    config.data = {
                        ...config.data,
                        api_token: this.user.api_token
                    };

                    return config;
                }
            )
        }
    }
</script>

<style scoped>

</style>