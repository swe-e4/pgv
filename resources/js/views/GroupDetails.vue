<template>
    <div>
        <div class="box" v-if="loading">
            <Alert type="info" title="Information" message="Gruppendetails werden geladen."/>
        </div>
        <div v-else>
            <div class="box">
                <div class="table center">
                    <h1>Gruppen: {{ this.group.name }}</h1>
                    <div class="scroll">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th>
                                        <a>
                                            <span>Termin</span>
                                        </a>
                                    </th>
                                    <th>
                                        <a>
                                            <span>Bewertung</span>
                                        </a>
                                    </th>
                                    <th>
                                        <a>
                                            <span>Ampelstatus</span>
                                        </a>
                                    </th>

                                    <th v-for="student in this.group.students" :key="student.data.id">
                                        <a>
                                            <span>{{ student.data.first_name}} {{ student.data.surname}}</span>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <a>
                                            <span>07.11.19</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a>
                                            <span>0</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a>
                                            <span>
                                                <div class="traffic-light-status green"></div>
                                            </span>
                                        </a>
                                    </td>
                                    <td v-for="student in this.group.students" :key="student.data.id">
                                        <a>
                                            <i class="fas fa-check"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a>
                                            <span>14.11.19</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a>
                                            <span>+</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a>
                                            <span>
                                                <div class="traffic-light-status yellow"></div>
                                            </span>
                                        </a>
                                    </td>
                                    <td v-for="student in this.group.students" :key="student.data.id">
                                        <a>
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a>
                                            <span>21.11.19</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a>
                                            <span>-</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a>
                                            <span>
                                                <div class="traffic-light-status red"></div>
                                            </span>
                                        </a>
                                    </td>
                                    <td v-for="student in this.group.students" :key="student.data.id">
                                        <a>
                                            <i class="fas fa-check"></i>
                                        </a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="chart pie">
                    <pie-chart :chartdata="pieDataOne"></pie-chart>
                </div>
                <div class="chart pie">
                    <pie-chart :chartdata="pieDataTwo"></pie-chart>
                </div>
            </div>

            <div class="box">
                <Alert type="info" title="Information" message="Meilensteine werden geladen." v-if="milestonesLoading"/>
                
                <div v-else>
                    <div class="alert info" v-if="milestones.length === 0">
                        <h1>Information</h1>
                        <p>Es exestieren derzeit keine Meilensteine.</p>
                    </div>

                    <div class="table" v-else>
                        <h1>Meilensteine</h1>
                        <div class="scroll">
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th class="sort" @click="milestonesOrderBy('name')" v-bind:class="[
                                            { up: milestonesOrderByColumn == 'name' && milestonesOrderByAsc == true },
                                            { down: milestonesOrderByColumn == 'name' && milestonesOrderByAsc == false }
                                            ]">
                                            <a>
                                                <span>Name</span>
                                            </a>
                                        </th>
                                        <th class="sort" @click="milestonesOrderBy('deadline')" v-bind:class="[
                                            { up: milestonesOrderByColumn == 'deadline' && milestonesOrderByAsc == true },
                                            { down: milestonesOrderByColumn == 'deadline' && milestonesOrderByAsc == false }
                                            ]">
                                            <a>
                                                <span>Abgabefrist</span>
                                            </a>
                                        </th>
                                        <th>
                                            <a>
                                                <span>Abgabe am</span>
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
                                        <td>
                                            <a>
                                                <span></span>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Alert from '../components/Alert';
    import PieChart from '../components/PieChart'
    export default {
        name: "GroupDetails",

        components: {
            Alert,
            PieChart
        },
        
        mounted() {
            axios.get('/api/group/' + this.$route.params.id + '?students')
                .then(response => {
                    this.group = response.data.data;
                    this.loading = false;
                })
                .catch(errors => {
                    if(errors.response.status === 404 || errors.response.status === 403) {
                        this.$router.push('/group');
                    }
                });
            axios.get('/api/milestone')
                .then(response => {
                    this.milestones = response.data.data;
                    this.milestonesLoading = false;
                })
                .catch(errors => {
                    this.milestonesLoading = false;
                });
        },

        data: function() {
            return {
                group: {},
                milestones: {},
                loading: true,
                milestonesLoading: true,
                milestonesOrderByColumn: 'name',
                milestonesOrderByAsc: true,
                pieDataOne: {
                    labels: ['Label 1', 'Label 2'],
                    datasets: [
                        {
                            backgroundColor: [
                                '#48bb78',
                                '#ed8936'
                            ],
                            data: [30, 60]
                        }
                    ]
                },
                pieDataTwo: {
                    labels: ['Label 1', 'Label 2', 'Label 3'],
                    datasets: [
                        {
                            backgroundColor: [
                                '#48bb78',
                                '#ed8936',
                                '#f56565'
                            ],
                            data: [30, 60, 80]
                        }
                    ]
                }
            }
        },

        methods: {
            milestonesOrderBy: function(milestonesOrderByColumn) {
                this.milestonesOrderByAsc = (this.milestonesOrderByColumn == milestonesOrderByColumn ? !this.milestonesOrderByAsc : true);
                this.milestonesOrderByColumn = milestonesOrderByColumn;
            }
        },

        computed: {
            filteredMilestones: function() {
                return _.orderBy(this.milestones, 'data.' + this.milestonesOrderByColumn, (this.milestonesOrderByAsc ? 'asc' : 'desc'));
            }
        }
    }
</script>

<style scoped>
</style>