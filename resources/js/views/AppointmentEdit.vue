<template>
    <div>
        <div class="box">
            <h1>Termin bearbeiten</h1>

            <Alert type="success" title="Bearbeitet" message="Termin wurde erfolgreich bearbeitet." v-if="success"/>
            
            <form @submit.prevent="submitForm">
                
                <div class="group">
                    <label for="group">Startdatum/-zeit:</label>
                    <datetime zone="Europe/Berlin" value-zone="Europe/Berlin" id="start" name="start" type="datetime" v-model="startTime" placeholder="Startdatum/-zeit" format="yyyy-MM-dd HH:mm" auto></datetime>
                </div>
                
                <div class="group">
                    <label for="group">Enddatum/-zeit:</label>
                    <datetime zone="Europe/Berlin" value-zone="Europe/Berlin" id="end" name="end" type="datetime" v-model="endTime" :min-datetime="startTime" placeholder="Enddatum/-zeit" format="yyyy-MM-dd HH:mm" auto></datetime>
                </div>

                <InputField name="name" label="Name" placeholder="Name" @update:field="form.name = $event" :errors="errors" :data="form.name"/>

                <div class="group">
                    <label for="group_id">Gruppe</label>

                    <Alert type="info" title="Information" message="Gruppen werden geladen." v-if="loading"/>
                        
                    <div v-else>

                        <div class="alert info" v-if="groups.length === 0">
                            <h1>Information</h1>
                            <p>Es exestieren derzeit keine Gruppen.</p>
                        </div>

                        <select id="group_id" name="group_id" v-else v-model="form.group_id">
                            <option v-for="group in groups" :key="group.data.id" v-bind:value="group.data.id" :selected="form.group_id == group.data.id">{{ group.data.name }}</option>
                        </select>
                    </div>
                </div>

                <div class="button-list">
                    <button class="half" type="submit">Termin bearbeiten</button>
                    <button class="half gray" type="reset" @click="$router.back();">Abbrechen</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import InputField from '../components/InputField';
    import Alert from '../components/Alert';
    import moment from 'moment'
    export default {
        name: "AppointmentEdit",

        components: {
            InputField,
            Alert
        },
        
        mounted() {
            axios.get('/api/appointment/' + this.$route.params.id)
                .then(response => {
                    this.form = response.data.data;
                    var tmpStart = this.form.start.split(' ');
                    var tmpEnd = this.form.end.split(' ');
                    this.startTime = tmpStart[0] + 'T' + tmpStart[1] + '.000';
                    this.endTime = tmpEnd[0] + 'T' + tmpEnd[1] + '.000';
                })
                .catch(errors => {
                    if(errors.response.status === 404 || errors.response.status === 403) {
                        this.$router.push('/appointment');
                    }
                });
            axios.get('/api/group')
                .then(response => {
                    this.groups = _.orderBy(response.data.data, 'data.name');
                    this.loading = false;
                })
                .catch(errors => {
                    this.loading = false;
                });
        },

        data: function() {
            return {
                startTime: '',
                endTime: '',
                form: {
                    'name': '',
                    'start': '',
                    'end': '',
                    'group_id': ''
                },
                success: false,
                errors: null,
                loading: true,
                groups: null,
            }
        },

        methods: {
            submitForm: function() {
                var tmpStart = this.startTime.split('.')[0].split('T');
                var tmpEnd = this.endTime.split('.')[0].split('T');
                this.form.start = tmpStart[0] + ' ' + tmpStart[1];
                this.form.end = tmpEnd[0] + ' ' + tmpEnd[1];

                axios.post('/api/appointment', this.form)
                    .then(response => {
                        this.success = true;
                    })
                    .catch(errors => {
                        this.success = false,
                        this.errors = errors.response.data.errors;
                    });
            }
        }
    }
</script>

<style scoped>

</style>