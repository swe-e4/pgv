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
                    <div class="search">
                        <i class="fas fa-search fa-xs"></i>
                        <input type="text" placeholder="Suche" aria-label="Suche" v-model="search">
                    </div>
                    <div class="scroll">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="sort" @click="orderBy('surname')" v-bind:class="[
                                        { up: orderByColumn == 'surname' && orderByAsc == true },
                                        { down: orderByColumn == 'surname' && orderByAsc == false }
                                        ]">
                                        <a>
                                            <span>Nachname</span>
                                        </a>
                                    </th>
                                    <th class="sort" @click="orderBy('first_name')" v-bind:class="[
                                        { up: orderByColumn == 'first_name' && orderByAsc == true },
                                        { down: orderByColumn == 'first_name' && orderByAsc == false }
                                        ]">
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
                                <tr v-for="adviser in filteredAdvisers" :key="adviser.data.id">
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
                                        <ul>
                                            <li>
                                                <a>
                                                    <span v-for="(group, index) in adviser.data.groups" :key="group.id">
                                                        {{ group.name }}<span v-if="index != adviser.data.groups.length - 1">, </span>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                    <td class="actions">
                                        <router-link :to="'/adviser/' + adviser.data.id + '/edit'">
                                            <i class="fas fa-pencil-alt"></i>
                                            <span>Bearbeiten</span>
                                        </router-link>
                                        <a @click="destroy(adviser)">
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
                search: '',
                orderByColumn: 'surname',
                orderByAsc: true,
            }
        },

        methods: {
            destroy: function(adviser) {
                axios.delete('/api/adviser/' + adviser.data.id)
                    .then(response => {
                        if(response.status === 204) {
                            this.success = true;
                            this.error = false;
                            this.advisers.splice(this.advisers.indexOf(adviser), 1);
                        } else {
                            this.success = false;
                            this.error = true;
                        }
                    })
                    .catch(errors => {
                        this.success = false;
                        this.error = true;
                    });
            },
            orderBy: function(orderByColumn) {
                this.orderByAsc = (this.orderByColumn == orderByColumn ? !this.orderByAsc : true);
                this.orderByColumn = orderByColumn;
            },
            groupsString: function(groups_string) {
                return groups_string.replace(';', ', ');
            }
        },

        computed: {
            filteredAdvisers: function() {
                return _.orderBy(this.advisers.filter((adviser) => {
                    return (
                        adviser.data.surname.toLowerCase().match(this.search.toLowerCase()) ||
                        adviser.data.first_name.toLowerCase().match(this.search.toLowerCase()) ||
                        adviser.data.groups_string.toLowerCase().match(this.search.toLowerCase())
                    );
                }), 'data.' + this.orderByColumn, (this.orderByAsc ? 'asc' : 'desc'));
            }
        }
    }
</script>

<style scoped>

</style>