<template>
    <nav>
        <div class="brand">
            <span>{{ app_name }}</span>
        </div>
        <div class="menu">
            <a>
                <span>{{ user.surname }}, {{ user.first_name }}</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <ul>
                <li class="separator">
                    <router-link to="/disabled" class="disabled">
                        <i class="fas fa-cog"></i>
                        <span>Einstellungen</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Ausloggen</span>
                    </router-link>
                </li>
            </ul>
        </div>
        <div class="toggle" @click="toggleNavbar">
            <i class="fas fa-bars fa-lg"></i>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "Navbar",

        props: [
            'app_name',
            'user'
        ],

        data: function() {
            return {
                isActive: false
            }
        },
        
        methods: {
            toggleNavbar: function() {
                this.isActive = !this.isActive;
                this.$emit("sidebarToggle", this.isActive);
            }
        },
        
        watch: {
            '$route' () {
                if(this.isActive) {
                    this.toggleNavbar();
                }
            }
        }
    }
</script>

<style scoped>

</style>