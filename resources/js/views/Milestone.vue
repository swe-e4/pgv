<template>
    <div>
        <div class="box">

            <div class="button-list">
                <router-link to="/milestone/create" tag="button">
                    <i class="fas fa-plus"></i>
                    <span>Meilenstein hinzufügen</span>
                </router-link>
            </div>

            <Alert type="error" title="Fehler" message="Meilenstein konnte nicht gelöscht werden." v-if="error"/>
            <Alert type="success" title="Gelöscht" message="Meilenstein wurde erfolgreich gelöscht." v-if="success"/>
            <Alert type="info" title="Information" message="Meilensteine werden geladen." v-if="loading"/>
            
            <div v-else>
                <div class="alert info" v-if="milestones.length === 0">
                    <h1>Information</h1>
                    <p>Es exestieren derzeit keine Meilensteine.</p>
                </div>
                <div class="table" v-else>
                    <h1>Meilensteine</h1>
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
                                    <th class="sort" @click="orderBy('deadline')" v-bind:class="[
                                        { up: orderByColumn == 'deadline' && orderByAsc == true },
                                        { down: orderByColumn == 'deadline' && orderByAsc == false }
                                        ]">
                                        <a>
                                            <span>Abgabefrist</span>
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
                                <tr v-for="milestone in filteredMilestones" :key="milestone.data.id">
                                    <td>
                                        <a>
                                            <span>{{ milestone.data.name }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a>
                                            <span>{{ milestone.data.deadline }}</span>
                                        </a>
                                    </td>
                                    <td class="actions">
                                        <router-link :to="'/milestone/' + milestone.data.id + '/edit'">
                                            <i class="fas fa-pencil-alt"></i>
                                            <span>Bearbeiten</span>
                                        </router-link>
                                        <a @click="destroy(milestone)">
                                            <i class="far fa-trash-alt"></i>
                                            <span>Löschen</span>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            
                <div class="button-list" v-if="milestones.length >= 10">
                    <router-link to="/milestone/create" tag="button">
                        <i class="fas fa-plus"></i>
                        <span>Meilenstein hinzufügen</span>
                    </router-link>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import Alert from '../components/Alert';
    export default {
        name: "Milestone",

        components: {
            Alert
        },

        mounted() {
            axios.get('/api/milestone')
                .then(response => {
                    this.milestones = response.data.data;
                    this.loading = false;
                })
                .catch(errors => {
                    this.loading = false;
                });
        },

        data: function() {
            return {
                loading: true,
                milestones: null,
                success: false,
                error: false,
                search: '',
                orderByColumn: 'name',
                orderByAsc: true,
            }
        },

        methods: {
            destroy: function(milestone) {
                axios.delete('/api/milestone/' + milestone.data.id)
                    .then(response => {
                        if(response.status === 204) {
                            this.success = true;
                            this.error = false;
                            this.milestones.splice(this.milestones.indexOf(milestone), 1);
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
            filteredMilestones: function() {
                return _.orderBy(this.milestones.filter((milestone) => {
                    return (
                        milestone.data.name.toLowerCase().match(this.search.toLowerCase()) ||
                        milestone.data.deadline.toLowerCase().match(this.search.toLowerCase())
                    );
                }), 'data.' + this.orderByColumn, (this.orderByAsc ? 'asc' : 'desc'));
            }
        }
    }
</script>

<style scoped>

</style>