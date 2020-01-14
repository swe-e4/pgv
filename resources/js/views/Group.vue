<template>
    <div>
        <div class="box">

            <div class="button-list" v-if="user.role_id == 1">
                <router-link to="/group/create" tag="button">
                    <i class="fas fa-plus"></i>
                    <span>Gruppe hinzufügen</span>
                </router-link>
            </div>

            <Alert type="error" title="Fehler" message="Gruppe konnte nicht gelöscht werden." v-if="error"/>
            <Alert type="success" title="Gelöscht" message="Gruppe wurde erfolgreich gelöscht." v-if="success"/>
            <Alert type="info" title="Information" message="Gruppen werden geladen." v-if="loading"/>
            
            <div v-else>
                <div class="alert info" v-if="groups.length === 0">
                    <h1>Information</h1>
                    <p>Es exestieren derzeit keine Gruppen.</p>
                </div>
                <div class="table" v-else>
                    <h1>Gruppen</h1>
                    <div class="search">
                        <i class="fas fa-search fa-xs"></i>
                        <input type="text" placeholder="Suche" aria-label="Suche" v-model="search">
                    </div>
                    <div class="scroll">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="sort" @click="orderBy('name')" v-bind:class="[
                                        { up: orderByColumn == 'name' && orderByAsc == true },
                                        { down: orderByColumn == 'name' && orderByAsc == false }
                                        ]">
                                        <a>
                                            <span>Name</span>
                                        </a>
                                    </th>
                                    <th class="sort" @click="orderBy('adviser.data.full_name')" v-bind:class="[
                                        { up: orderByColumn == 'adviser.data.full_name' && orderByAsc == true },
                                        { down: orderByColumn == 'adviser.data.full_name' && orderByAsc == false }
                                        ]">
                                        <a>
                                            <span>Betreuer</span>
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
                                <tr v-for="group in filteredGroups" :key="group.data.id">
                                    <td>
                                        <a>
                                            <span>{{ group.data.name }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a>
                                            <span>{{ group.data.adviser ? group.data.adviser.data.full_name : '' }}</span>
                                        </a>
                                    </td>
                                    <td class="actions">
                                        <router-link :to="'/group/' + group.data.id + '/edit'" v-if="user.role_id == 1">
                                            <i class="fas fa-pencil-alt"></i>
                                            <span>Bearbeiten</span>
                                        </router-link>
                                        <a @click="destroy(group)" v-if="user.role_id == 1">
                                            <i class="far fa-trash-alt"></i>
                                            <span>Löschen</span>
                                        </a>
                                        <router-link :to="'/group/' + group.data.id">
                                            <i class="fas fa-info"></i>
                                            <span>Details</span>
                                        </router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            
                <div class="button-list" v-if="groups.length >= 10 && user.role_id == 1">
                    <router-link to="/group/create" tag="button">
                        <i class="fas fa-plus"></i>
                        <span>Gruppe hinzufügen</span>
                    </router-link>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import Alert from '../components/Alert';
    export default {
        name: "Group",

        components: {
            Alert
        },

        props: [
            'user',
        ],

        mounted() {
            axios.get('/api/group')
                .then(response => {
                    this.groups = response.data.data;
                    this.loading = false;
                })
                .catch(errors => {
                    this.loading = false;
                });
        },

        data: function() {
            return {
                loading: true,
                groups: null,
                success: false,
                error: false,
                search: '',
                orderByColumn: 'name',
                orderByAsc: true,
            }
        },

        methods: {
            destroy: function(group) {
                axios.delete('/api/group/' + group.data.id)
                    .then(response => {
                        if(response.status === 204) {
                            this.success = true;
                            this.error = false;
                            this.groups.splice(this.groups.indexOf(group), 1);
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
            }
        },

        computed: {
            filteredGroups: function() {
                return _.orderBy(this.groups.filter((group) => {
                    return (
                        group.data.name.toLowerCase().match(this.search.toLowerCase()) ||
                        (group.data.adviser && group.data.adviser.data.full_name.toLowerCase().match(this.search.toLowerCase()))
                    );
                }), 'data.' + this.orderByColumn, (this.orderByAsc ? 'asc' : 'desc'));
            }
        }
    }
</script>

<style scoped>

</style>