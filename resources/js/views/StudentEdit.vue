<template>
    <div>
        <div class="box">
            <h1>Student bearbeiten</h1>

            <Alert type="success" title="Bearbeitet" message="Student wurde erfolgreich bearbeitet." v-if="success"/>

            <form @submit.prevent="submitForm">
                <InputField name="surname" label="Nachname" placeholder="Mustermann" @update:field="form.surname = $event" :errors="errors" :data="form.surname"/>
                <InputField name="first_name" label="Vorname" placeholder="Max" @update:field="form.first_name = $event" :errors="errors" :data="form.first_name"/>
                <InputField name="email" label="E-Mail" placeholder="max.mustermann@example.com" @update:field="form.email = $event" :errors="errors" :data="form.email"/>
                <InputField name="student_number" label="Matrikelnummer" placeholder="123456789" @update:field="form.student_number = $event" :errors="errors" :data="form.student_number"/>

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
                    <button class="half" type="submit">Änderungen speichern</button>
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
        name: "StudentEdit",

        components: {
            InputField,
            Alert
        },

        mounted() {
            axios.get('/api/student/' + this.$route.params.id)
                .then(response => {
                    this.form = Object.assign({'groupUpdate': true}, response.data.data);
                    this.form.group_id = response.data.data.group.data.id;
                })
                .catch(errors => {
                    if(errors.response.status === 404 || errors.response.status === 403) {
                        this.$router.push('/student');
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
                form: {
                    'surname': '',
                    'first_name': '',
                    'email': '',
                    'student_number': '',
                    'group_id': '',
                },
                success: false,
                errors: null,
                loading: true,
                groups: null,
            }
        },

        methods: {
            submitForm: function() {
                axios.patch('/api/student/' + this.$route.params.id, this.form)
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