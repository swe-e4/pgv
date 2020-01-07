<template>
    <div>
        <div class="box">

            <div class="button-list">
                <router-link to="/appointment/create" tag="button">
                    <i class="fas fa-plus"></i>
                    <span>Termin hinzufügen</span>
                </router-link>
            </div>

            <Alert type="error" title="Fehler" message="Termin konnte nicht gelöscht werden." v-if="error"/>
            <Alert type="success" title="Gelöscht" message="Termin wurde erfolgreich gelöscht." v-if="success"/>
            <Alert type="info" title="Information" message="Termine werden geladen." v-if="loading"/>
            
            <div v-else>

                <v-date-picker
                    v-if="!loading"
                    v-model="selectDate"
                    is-inline
                    :select-attribute="attribute"
                    :available-dates="dates"/>

                <div>
                    <div class="alert info" v-if="appointments.length === 0">
                        <h1>Information</h1>
                        <p>Es exestieren derzeit keine Termine.</p>
                    </div>
                    <div class="table" v-else>
                        <h1>Termine</h1>
                        <div class="scroll">
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th>
                                            <a>
                                                <span>Zeit</span>
                                            </a>
                                        </th>
                                        <th class="sort" @click="orderBy('name')" v-bind:class="[
                                            { up: orderByColumn == 'name' && orderByAsc == true },
                                            { down: orderByColumn == 'name' && orderByAsc == false }
                                            ]">
                                            <a>
                                                <span>Name</span>
                                            </a>
                                        </th>
                                        <th class="sort" @click="orderBy('group.data.name')" v-bind:class="[
                                            { up: orderByColumn == 'group.data.name' && orderByAsc == true },
                                            { down: orderByColumn == 'group.data.name' && orderByAsc == false }
                                            ]">
                                            <a>
                                                <span>Gruppe</span>
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
                                    <tr v-for="appointment in filteredAppointments" :key="appointment.data.id">
                                        <td>
                                            <a>
                                                <span>{{ appointment.data.start.split(' ')[1].slice(0,5) }} - {{ appointment.data.end.split(' ')[1].slice(0,5) }}</span>
                                            </a>
                                        </td>
                                        <td>
                                            <a>
                                                <span>{{ appointment.data.name }}</span>
                                            </a>
                                        </td>
                                        <td>
                                            <a>
                                                <span>{{ appointment.data.group.data.name }}</span>
                                            </a>
                                        </td>
                                        <td class="actions">
                                            <router-link :to="'/appointment/' + appointment.data.id + '/edit'">
                                                <i class="fas fa-pencil-alt"></i>
                                                <span>Bearbeiten</span>
                                            </router-link>
                                            <a @click="destroy(appointment)">
                                                <i class="far fa-trash-alt"></i>
                                                <span>Löschen</span>
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
    import DatePicker from 'v-calendar/lib/components/date-picker.umd'
    import moment from 'moment'
    export default {
        name: "Appointment",

        components: {
            Alert,
            DatePicker,
        },

        mounted() {
            axios.get('/api/appointment')
                .then(response => {
                    this.appointments = response.data.data;
                    var tmpDates = [];
                    
                    for(var apointment in this.appointments) {
                        var tmpDate = this.appointments[apointment].data.start.split(' ')[0];

                        if(!tmpDates.includes(tmpDate)) {
                            tmpDates.push(tmpDate);
                        }
                    }

                    for(var tmp in tmpDates) {
                        var tmpDate = tmpDates[tmp].split('-');
                        this.dates.push({
                            start: new Date(tmpDate[0], tmpDate[1] - 1, tmpDate[2]),
                            span: 1
                        });
                    }

                    this.loading = false;
                })
                .catch(errors => {
                    this.loading = false;
                });
        },

        data: function() {
            return {
                loading: true,
                appointments: null,
                success: false,
                error: false,
                date: null,
                selectDate: null,
                dates: [],
                attribute: {
                    bar: true
                },
                orderByColumn: 'name',
                orderByAsc: true,
            }
        },

        methods: {
            destroy: function(appointment) {
                axios.delete('/api/appointment/' + appointment.data.id)
                    .then(response => {
                        if(response.status === 204) {
                            this.success = true;
                            this.error = false;
                            var tmpDate = appointment.data.start.split(' ')[0].split('-');
                            this.appointments.splice(this.appointments.indexOf(appointment), 1);
                            if(this.filteredAppointments.length === 0) {
                                var tmpDate = {
                                        start: new Date(tmpDate[0], tmpDate[1] - 1, tmpDate[2]),
                                        span: 1
                                };

                                for(var date in this.dates) {
                                    console.log(this.dates[date].start);
                                    if(String(this.dates[date].start) == String(tmpDate.start)) {
                                        this.dates.splice(date, 1);
                                        break;
                                    }
                                }
                            }
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

        watch: {
            selectDate() {
                this.date = moment(String(this.selectDate)).format('DD.MM.YYYY');
            }
        },

        computed: {
            filteredAppointments: function() {
                return _.orderBy(this.appointments.filter((appointment) => {
                    if(this.selectDate == null) {
                        return false;
                    }
                    var tmpDate = appointment.data.start.split(' ')[0].split('-');
                    return (
                        String(tmpDate[2] + '.' + tmpDate[1] + '.' + tmpDate[0]) == String(this.date)
                    );
                }), 'data.' + this.orderByColumn, (this.orderByAsc ? 'asc' : 'desc'));
            }
        }
    }
</script>

<style scoped>

</style>