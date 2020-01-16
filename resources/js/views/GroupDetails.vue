<template>
    <div>
        <div class="box" v-if="loading">
            <Alert type="info" title="Information" message="Gruppendetails werden geladen."/>
        </div>
        <div v-else>
            
            <Alert type="success" title="Gesendet" message="Die Mail wird an die Gruppe gesedent." v-if="success"/>
                
            <div class="modal box" v-bind:class="{hidden: hidden}">
                <h1>E-Mail an alle Gruppenmitglieder</h1>
                 <form>
                    <textarea rows=10 v-model="form.content"></textarea>

                    <div class="button-list">
                        <button class="half" type="submit" @click="sendMail()">Senden</button>
                        <button class="half gray" type="reset" @click="closeModel()">Abbrechen</button>
                    </div>
                </form>
            </div>
            <div class="box">

                <div class="button-list" v-if="user.role_id == 2">
                    <button @click="openModel()">
                        <i class="fas fa-reply-all"></i>
                        <span>E-Mail an alle Gruppenmitglieder</span>
                    </button>
                </div>

                <div class="table center">
                    <h1>Gruppen: {{ this.group.name }}</h1>
                    <div class="scroll max">
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

                                    <th v-for="student in group.students" :key="student.data.id">
                                        <a>
                                            <span>{{ student.data.first_name}} {{ student.data.surname}}</span>
                                        </a>
                                    </th>
                                    
                                    <th class="actions" v-if="user.role_id == 2">
                                        <a>
                                            <span>Aktion</span>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="appointment in group.appointments" :key="appointment.data.id">
                                    <td>
                                        <a>
                                            <span>{{ appointment.data.name }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a>
                                            <span>{{ appointment.data.rating }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a>
                                            <span>
                                                <div class="traffic-light-status" v-bind:class="appointment.data.traffic_light_status"></div>
                                            </span>
                                        </a>
                                    </td>
                                    <td v-for="student in group.students" :key="student.data.id">
                                        <a>
                                            <i class="fas fa-check" v-if="appointment.data.studentIDs.includes(student.data.id)"></i>
                                            <i class="fas fa-times" v-else></i>
                                        </a>
                                    </td>
                                    <td class="actions" v-if="user.role_id == 2">
                                        <router-link :to="'/appointment/' + appointment.data.id + ''">
                                            <i class="fas fa-pencil-alt"></i>
                                            <span>Bearbeiten</span>
                                        </router-link>
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
                    <h1>Bewertung</h1>
                </div>
                <div class="chart pie">
                    <pie-chart :chartdata="pieDataTwo"></pie-chart>
                    <h1>Ampelstatus</h1>
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
                                            <datetime zone="Europe/Berlin" value-zone="Europe/Berlin" v-model="milestone.data.done_on" format="yyyy-MM-dd" auto v-if="user.role_id == 2" @close="updateMilestone(milestone.data.id, milestone.data.done_on)"></datetime>
                                            <a v-else>
                                                <span>{{ milestone.data.done_on != null ? milestone.data.done_on : '-' }}</span>
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

        props: [
            'user',
        ],

        components: {
            Alert,
            PieChart
        },
        
        mounted() {
            axios.get('/api/group/' + this.$route.params.id + '?students&appointments&studentList')
                .then(response => {
                    this.group = response.data.data;
                    this.loading = false;

                    this.pieDataOne.labels = ['+','0','-'];//this.group.ratings.filter(val=>val).sort();
                    for(var label in this.pieDataOne.labels) {
                        this.pieDataOne.datasets[0].data.push(this.group.rating_count[this.pieDataOne.labels[label]]);
                    }

                    this.pieDataTwo.labels = ['red', 'yellow', 'green'];//this.group.traffic_lights.filter(val=>val).sort();
                    for(var label in this.pieDataTwo.labels) {
                        this.pieDataTwo.datasets[0].data.push(this.group.traffic_light_status_count[this.pieDataTwo.labels[label]]);
                    }

                })
                .catch(errors => {
                    if(errors.response.status === 404 || errors.response.status === 403) {
                        this.$router.push('/group');
                    }
                });
            axios.get('/api/milestone?group_id=' + this.$route.params.id)
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
                form: {
                    'content': ''
                },
                hidden: true,
                success: false,
                pieDataOne: {
                    labels: [],
                    datasets: [
                        {
                            backgroundColor: [
                                '#48bb78',
                                '#ecc94b',
                                '#f56565',
                            ],
                            data: []
                        }
                    ]
                },
                pieDataTwo: {
                    labels: [],
                    datasets: [
                        {
                            backgroundColor: [
                                '#f56565',
                                '#ecc94b',
                                '#48bb78',
                            ],
                            data: []
                        }
                    ]
                }
            }
        },

        methods: {
            milestonesOrderBy: function(milestonesOrderByColumn) {
                this.milestonesOrderByAsc = (this.milestonesOrderByColumn == milestonesOrderByColumn ? !this.milestonesOrderByAsc : true);
                this.milestonesOrderByColumn = milestonesOrderByColumn;
            },
            updateMilestone: function(milestoneID, doneOn) {
                axios.patch('/api/group/' + this.$route.params.id, {
                    'milestoneID': milestoneID,
                    'doneOn': doneOn
                    })
                    .then(response => {
                        console.log(response);
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            openModel() {
                this.hidden = false;
            },
            closeModel() {
                this.hidden = true;
            },
            sendMail() {
                axios.post('/api/sendmail', {
                    'content': this.form.content,
                    'group_id': this.group.id
                    })
                    .then(response => {
                        this.success = true;
                        this.form = {
                                'content': '',
                            };
                        this.hidden = true;
                    })
                    .catch(errors => {
                        this.success = false;
                    });
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