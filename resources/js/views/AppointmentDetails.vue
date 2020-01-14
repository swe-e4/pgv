<template>
    <div>
        <Alert type="success" title="Bearbeitet" message="Termindetails wurden erfolgreich bearbeitet." v-if="success"/>

        <div class="box" v-if="loading">
            <Alert type="info" title="Information" message="Termindetails werden geladen."/>
        </div>
        <div class="box" v-else>
            <h1>{{ appointment.name }}</h1>
            
            <form @submit.prevent="submitForm">

                <h2>Anwesend</h2>
                <div class="group checkbox">
                    <div v-for="student in appointment.group.data.students" :key="student.data.id">
                        
                        <input type="checkbox" v-bind:id="student.data.id" name="studentList" v-model="form.studentList" v-bind:value="student.data.id">
                        <label v-bind:for="student.data.id">{{ student.data.surname }}, {{ student.data.first_name }}</label>
                    
                    </div>
                </div>

                <h2>Terminbewertung</h2>
                <div class="group checkbox">
                    <div>
                        <input type="radio" id="plus" name="rating" value="+" v-model="form.rating" v-bind:checked="appointment.rating == '+'">
                        <label for="plus">+</label>
                    </div>
                    <div>
                        <input type="radio" id="zero" name="rating" value="0" v-model="form.rating" v-bind:checked="appointment.rating == '0'">
                        <label for="zero">0</label>
                    </div>
                    <div>
                        <input type="radio" id="minus" name="rating" value="-" v-model="form.rating" v-bind:checked="appointment.rating == '-'">
                        <label for="minus">-</label>
                    </div>
                </div>

                
                <h2>Ampelstatus</h2>
                
                <div class="group checkbox">
                    <div>
                        <input type="radio" id="red" name="traffic_light_status" value="red" v-model="form.traffic_light_status" v-bind:checked="appointment.traffic_light_status == 'red'">
                        <label for="red">Rot</label>
                    </div>
                    <div>
                        <input type="radio" id="yellow" name="traffic_light_status" value="yellow" v-model="form.traffic_light_status" v-bind:checked="appointment.traffic_light_status == 'yellow'">
                        <label for="yellow">Gelb</label>
                    </div>
                    <div>
                        <input type="radio" id="green" name="traffic_light_status" value="green" v-model="form.traffic_light_status" v-bind:checked="appointment.traffic_light_status == 'green'">
                        <label for="green">Grün</label>
                    </div>
                </div>
                <h2>Beschreibung</h2>
                <textarea name="description" v-model="form.description" rows="8"></textarea>


                <div class="button-list">
                    <button class="half" type="submit">Speichern</button>
                    <button class="half gray" type="reset" @click="$router.back();">Abbrechen</button>
                </div>
            
            </form>
        </div>
    </div>
</template>

<script>
    import Alert from '../components/Alert';
    export default {
        name: "AppointmentDetails",

        components: {
            Alert
        },
        
        mounted() {
            axios.get('/api/appointment/' + this.$route.params.id + '?students')
                .then(response => {
                    this.appointment = response.data.data;
                    this.form.rating = this.appointment.rating;
                    this.form.traffic_light_status = this.appointment.traffic_light_status;
                    this.form.description = this.appointment.description;
                    this.loading = false;
                })
                .catch(errors => {
                    if(errors.response.status === 404 || errors.response.status === 403) {
                        router.go(-1)
                    }
                });
        },

        data: function() {
            return {
                appointment: {},
                form: {
                    'rating': 0,
                    'traffic_light_status': 'green',
                    'description': '',
                    'students': [],
                },
                loading: true,
                success: false,
            }
        },

        methods: {
            submitForm: function() {
                console.log(this.form);
                axios.patch('/api/appointment/' + this.$route.params.id, this.form)
                    .then(response => {
                        this.success = true;
                        console.log(response);
                    })
                    .catch(errors => {
                        this.success = false,
                        console.log(response);
                        this.errors = errors.response.data.errors;
                    });
            }
        },
    }
</script>

<style scoped>
</style>