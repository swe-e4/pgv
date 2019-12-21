<template>
    <div class="sidebar" v-bind:class="{active: active}">
        <ul>
            <li>
                <router-link to="/">
                    <i class="fas fa-thumbtack"></i>
                    <span>Übersicht</span>
                </router-link>
            </li>
        </ul>
        <ul>
            <li>
                <router-link to="/adviser">
                    <i class="fas fa-users"></i>
                    <span>Betreuer</span>
                </router-link>
            </li>
            <li>
                <router-link to="/group">
                    <i class="fas fa-project-diagram"></i>
                    <span>Gruppe</span>
                </router-link>
            </li>
            <li>
                <router-link to="/student">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Studenten</span>
                </router-link>
            </li>
            <li>
                <router-link to="/disabled" class="disabled">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Termine</span>
                </router-link>
            </li>
            <li>
                <router-link to="/milestone">
                    <i class="fas fa-briefcase"></i>
                    <span>Meilensteine</span>
                </router-link>
            </li>
        </ul>
        <ul class="only-mobile">
            <li>
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
</template>

<script>
    export default {
        name: "Sidebar",

        props: [
            'active',
        ]
    }
</script>

<style scoped>

</style>