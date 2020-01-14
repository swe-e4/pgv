<template>
    <div>
        <div class="box">
            <Alert type="info" title="Information" message="Wochenplan wird geladen." v-if="loadingAppointments"/>
            
            <div v-else>
                <div class="alert info" v-if="appointments.length === 0">
                    <h1>Information</h1>
                    <p>Diese Woche stehen keine Termine an.</p>
                </div>
                <div class="table" v-else>
                    <h1>Wochenplan</h1>
                    <div class="scroll">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th>
                                        <a>
                                            <span>Montag</span>
                                        </a>
                                    </th>
                                    <th>
                                        <a>
                                            <span>Dienstag</span>
                                        </a>
                                    </th>
                                    <th>
                                        <a>
                                            <span>Mittwoch</span>
                                        </a>
                                    </th>
                                    <th>
                                        <a>
                                            <span>Donnerstag</span>
                                        </a>
                                    </th>
                                    <th>
                                        <a>
                                            <span>Freitag</span>
                                        </a>
                                    </th>
                                    <th>
                                        <a>
                                            <span>Samstag</span>
                                        </a>
                                    </th>
                                    <th>
                                        <a>
                                            <span>Sonntag</span>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, rowIndex) in appointments" :key="rowIndex">
                                    <td v-for="(day, dayIndex) in row" :key="dayIndex">
                                        <a v-if="day != false">
                                            <span>{{ day.data.group.data.name }}</span>
                                            <small>{{ day.data.start.split(' ')[1] }} - {{ day.data.end.split(' ')[1] }}</small>
                                        </a>
                                        <a v-else>
                                            -
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="box">
            <Alert type="info" title="Information" message="Gruppen werden geladen." v-if="loadingGroups"/>
            
            <div v-else>
                <div class="alert info" v-if="groups.length === 0">
                    <h1>Information</h1>
                    <p>Es exestieren derzeit keine Gruppen.</p>
                </div>
                <div class="table" v-else>
                    <h1>Termine</h1>                    
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
                                            <span>Gruppe</span>
                                        </a>
                                    </th>
                                    <th class="sort" @click="orderBy('adviser.data.full_name')" v-bind:class="[
                                        { up: orderByColumn == 'adviser.data.full_name' && orderByAsc == true },
                                        { down: orderByColumn == 'adviser.data.full_name' && orderByAsc == false }
                                        ]" v-if="user.role_id == 1">
                                        <a>
                                            <span>Betreuer</span>
                                        </a>
                                    </th>
                                    <th>
                                        <a>
                                            <span>Nächster Termin</span>
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
                                    <td v-if="user.role_id == 1">
                                        <a>
                                            <span>{{ group.data.adviser ? group.data.adviser.data.full_name : '' }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a>
                                            <span>{{ group.data.next_appointment ? group.data.next_appointment.data.start : ''}}</span>
                                        </a>
                                    </td>
                                    <td class="actions">
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
            </div>
        </div>
    </div>
</template>

<script>
    import Alert from '../components/Alert';
    export default {
        name: "Overview",

        components: {
            Alert
        },

        props: [
            'user',
        ],
        
        mounted() {
            axios.get('/api/appointment?week')
                .then(response => {
                    this.appointments = response.data;
                    this.loadingAppointments = false;
                })
                .catch(errors => {
                    this.loadingAppointments = false;
                });
            axios.get('/api/group?overview')
                .then(response => {
                    this.groups = response.data.data;
                    this.loadingGroups = false;
                })
                .catch(errors => {
                    this.loadingGroups = false;
                });
        },

        data: function() {
            return {
                loadingGroups: true,
                groups: null,
                search: '',
                orderByColumn: 'name',
                orderByAsc: true,
                loadingAppointments: true,
                appointments: null,
            }
        },

        methods: {
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