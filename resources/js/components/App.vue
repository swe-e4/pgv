<template>
    <div>
        <!-- Navbar -->
        <Navbar :app_name="app_name" :user="user" @sidebarToggle="sidebarToggle"></Navbar>

        <!-- Main -->
        <main>

            <!-- Sidebar -->
            <Sidebar :active="this.sidebarActive"></Sidebar>

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
            'app_name',
            'user'
        ],

        created() {
            this.title = this.$route.meta.title;

            window.user = this.user;
            window.axios.interceptors.request.use(
                (config) => {
                    if(config.method === 'get') {
                        config.url = config.url + '?api_token=' + this.user.api_token;
                    } else {
                        config.data = {
                            ...config.data,
                            api_token: this.user.api_token
                        };
                    }

                    return config;
                }
            )
        },

        data: function() {
            return {
                title: '',
                sidebarActive: false
            }
        },

        watch: {
            $route(to, from) {
                this.title = to.meta.title;
            },

            title() {
                document.title = this.app_name + ' - ' + this.title; 
            }
        },
        methods: {
            sidebarToggle(variable) {
                this.sidebarActive = variable
            }
        }
    }
</script>

<style scoped>

</style>