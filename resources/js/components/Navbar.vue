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
        <div class="toggle">
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
    }
</script>

<style scoped>

</style>