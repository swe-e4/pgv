<template>
    <div>
        <div class="box">

            <div class="button-list">
                <button class="half gray disabled">
                    <i class="fas fa-upload"></i>
                    <span>Betreuer importieren</span>
                </button>
                <router-link to="/adviser/create" tag="button" class="half">
                    <i class="fas fa-user-plus"></i>
                    <span>Betreuer hinzufügen</span>
                </router-link>
            </div>

            <Alert type="error" title="Fehler" message="Betreuer konnte nicht gelöscht werden." v-if="error"/>
            <Alert type="success" title="Gelöscht" message="Betreuer wurde erfolgreich gelöscht." v-if="success"/>
            <Alert type="info" title="Information" message="Betreuer werden geladen." v-if="loading"/>
            
            <div v-else>
                <div class="alert info" v-if="advisers.length === 0">
                    <h1>Information</h1>
                    <p>Es exestieren derzeit keine Betreuer.</p>
                </div>
                <div class="table" v-else>
                    <h1>Betreuer</h1>
                    <div class="search disabled">
                        <i class="fas fa-search fa-xs"></i>
                        <input type="text" placeholder="Suche" aria-label="Suche" disabled>
                    </div>
                    <div class="scroll">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="sort up">
                                        <a>
                                            <span>Nachname</span>
                                        </a>
                                    </th>
                                    <th class="sort">
                                        <a>
                                            <span>Vorname</span>
                                        </a>
                                    </th>
                                    <th>
                                        <a>
                                            <span>Gruppen</span>
                                        </a>
                                    </th>
                                    <th class="actions">
                                        <a>
                                            <span>Aktion</span>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(adviser, index) in advisers" :key="index">
                                    <td>
                                        <a>
                                            <span>{{ adviser.data.surname }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a>
                                            <span>{{ adviser.data.first_name }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <ul class="comma-separated">
                                            <li v-for="group in adviser.data.groups" :key="group.id">
                                                <a>
                                                    <span>{{ group.name }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                    <td class="actions">
                                        <router-link :to="'/adviser/' + adviser.data.id + '/edit'">
                                            <i class="fas fa-pencil-alt"></i>
                                            <span>Bearbeiten</span>
                                        </router-link>
                                        <a @click="destroy(adviser.data.id, index)">
                                            <i class="far fa-trash-alt"></i>
                                            <span>Löschen</span>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            
                <div class="button-list" v-if="advisers.length >= 10">
                    <button class="half gray disabled">
                        <i class="fas fa-upload"></i>
                        <span>Betreuer importieren</span>
                    </button>
                    <router-link to="/adviser/create" tag="button" class="half">
                        <i class="fas fa-user-plus"></i>
                        <span>Betreuer hinzufügen</span>
                    </router-link>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import Alert from '../components/Alert';
    export default {
        name: "Adviser",

        components: {
            Alert
        },

        mounted() {
            axios.get('/api/adviser')
                .then(response => {
                    this.advisers = response.data.data;
                    this.loading = false;
                })
                .catch(errors => {
                    this.loading = false;
                });
        },

        data: function() {
            return {
                loading: true,
                advisers: null,
                success: false,
                error: false,
            }
        },

        methods: {
            destroy: function(adviserID, index) {
                axios.delete('/api/adviser/' + adviserID)
                    .then(response => {
                        if(response.status === 204) {
                            this.success = true;
                            this.error = false;
                            this.advisers.splice(index, 1);
                        } else {
                            this.success = false;
                            this.error = true;
                        }
                    })
                    .catch(errors => {
                        this.success = false;
                        this.error = true;
                    });
            }
        }
    }
</script>

<style scoped>

</style>