<template>
    <div>
        <div class="box">
            <h1>Meilenstein hinzufügen</h1>

            <Alert type="success" title="Hinzugefügt" message="Termin wurde erfolgreich hinzugefügt." v-if="success"/>
            
            <form @submit.prevent="submitForm">
                
                <div class="group">
                    <label for="group">Startdatum/-zeit:</label>
                    <datetime type="datetime" v-model="form.start" placeholder="Startdatum/-zeit" format="yyyy-MM-dd HH:mm" auto></datetime>
                </div>
                
                <div class="group">
                    <label for="group">Enddatum/-zeit:</label>
                    <datetime type="datetime" v-model="form.end" placeholder="Enddatum/-zeit" format="yyyy-MM-dd HH:mm" auto></datetime>
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
                            <option v-for="group in groups" :key="group.data.id" v-bind:value="group.data.id">{{ group.data.name }}</option>
                        </select>
                    </div>
                </div>

                <div class="button-list">
                    <button class="half" type="submit">Termin hinzufügen</button>
                    <button class="half gray" type="reset" @click="$router.back();">Abbrechen</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import InputField from '../components/InputField';
    import Alert from '../components/Alert';
    export default {
        name: "AppointmentCreate",

        components: {
            InputField,
            Alert
        },
        
        mounted() {
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
                console.log(this.form.start)
                //this.form.deadline = this.form.deadline.split("T00:00:00.000Z")[0];
                /*
                axios.post('/api/milestone', this.form)
                    .then(response => {
                        this.success = true;
                        this.form = {
                                'name': '',
                                'start': '',
                                'end': '',
                                'group_id': ''
                            };
                    })
                    .catch(errors => {
                        this.success = false,
                        this.errors = errors.response.data.errors;
                    });*/
            }
        }
    }
</script>

<style scoped>

</style>