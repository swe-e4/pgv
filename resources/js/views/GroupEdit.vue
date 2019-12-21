<template>
    <div>
        <div class="box">
            <h1>Gruppe bearbeiten</h1>
            <div>
                <div class="half">
                    <Alert type="success" title="Hinzugefügt" message="Gruppe wurde erfolgreich hinzugefügt." v-if="success"/>
                
                    <form @submit.prevent="submitForm">
                        <InputField name="name" label="Gruppenname" placeholder="Gruppenname" @update:field="form.name = $event" :errors="errors" :data="form.name"/>

                        <div class="group">
                            <label for="group">Betreuer</label>

                            <Alert type="info" title="Information" message="Betreuer werden geladen." v-if="loading"/>
                            
                            <div v-else>

                                <div class="alert info" v-if="advisers.length === 0">
                                    <h1>Information</h1>
                                    <p>Es exestieren derzeit keine Betreuer.</p>
                                </div>

                                <select id="adviser_id" name="adviser_id" v-else v-model="form.adviser_id">
                                    <option v-for="adviser in advisers" :key="adviser.data.id" v-bind:value="adviser.data.id" :selected="form.adviser_id === adviser.data.id">{{ adviser.data.full_name }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="group">
                            <label>Studenten</label>
                            
                            <ul v-if="form.students && form.students.length !== 0" class="comma-separated">
                                <li v-for="student in filteredFormStudents" :key="student.data.id">{{ student.data.student_number }}</li>
                            </ul>
                        </div>

                        <div class="button-list">
                            <button class="half" type="submit">Änderungen speichern</button>
                            <button class="half gray" type="reset" @click="$router.back();">Abbrechen</button>
                        </div>
                    </form>
                </div>
                <div class="half">
                    <form @submit.prevent="addStudent">
                        <div class="group">
                            <label for="group">Student hinzufügen</label>
                            
                            <Alert type="error" title="Fehler" message="Student konnte nicht hinzugefügt werden." v-if="studentError"/>
                            <Alert type="success" title="Hinzugefügt" message="Student wurde erfolgreich hinzugefügt." v-if="studentSuccess"/>

                            <Alert type="info" title="Information" message="Studenten werden geladen." v-if="studentsLoading"/>
                            
                            <div v-else>

                                <div class="alert info" v-if="students.length === 0">
                                    <h1>Information</h1>
                                    <p>Es exestieren derzeit keine Studenten.</p>
                                </div>

                                <select id="id" name="id" v-else v-model="studentForm.id" placeholder="Matrikelnummer">
                                    <option v-for="student in studentsList" :key="student.data.id" v-bind:value="student.data.id">{{ student.data.student_number }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="button-list">
                            <button type="submit">Student hinzufügen</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import InputField from '../components/InputField';
    import Alert from '../components/Alert';
    export default {
        name: "GroupEdit",

        components: {
            InputField,
            Alert
        },
        
        mounted() {
            axios.get('/api/group/' + this.$route.params.id + '?students')
                .then(response => {
                    this.form = response.data.data;
                })
                .catch(errors => {
                    if(errors.response.status === 404 || errors.response.status === 403) {
                        this.$router.push('/group');
                    }
                });
            axios.get('/api/adviser')
                .then(response => {
                    this.advisers = _.orderBy(response.data.data, 'data.full_name');
                    this.loading = false;
                })
                .catch(errors => {
                    this.loading = false;
                });
            axios.get('/api/student?students')
                .then(response => {
                    this.students = _.orderBy(response.data.data, 'data.student_number');
                    this.studentsLoading = false;
                })
                .catch(errors => {
                    this.studentsLoading = false;
                });
        },

        data: function() {
            return {
                form: {
                    'name': '',
                    'adviser_id': null
                },
                studentForm: {
                    'id': '',
                },
                success: false,
                errors: null,
                studentSuccess: false,
                studentError: false,
                loading: true,
                studentsLoading: true,
                advisers: {},
                students: {}
            }
        },

        methods: {
            submitForm: function() {
                axios.patch('/api/group/' + this.$route.params.id, this.form)
                    .then(response => {
                        this.success = true;
                    })
                    .catch(errors => {
                        this.success = false,
                        this.errors = errors.response.data.errors;
                    });
            },
            addStudent: function() {
                axios.patch('/api/student/' + this.studentForm.id, {'group_id': this.$route.params.id})
                    .then(response => {
                        this.studentSuccess = true;
                        this.studentError = false;
                        this.studentForm = {'id': '',};
                        this.form.students.push(response.data);
                    })
                    .catch(errors => {
                        this.studentSuccess = false,
                        this.studentError = true;
                    });
            }
        },

        computed: {
            filteredFormStudents: function() {
                return _.orderBy(this.form.students, 'data.student_number');
            },
            studentsList: function() {
                return _.orderBy(this.students.filter((student) => {
                    if(this.form.students) {
                        for (var i = 0; i < this.form.students.length; i++) {
                            if(this.form.students[i].data.id == student.data.id) {
                                return false;
                            }
                        }
                        return true;
                    }
                }), 'data.student_number');
            }
        }
    }
</script>

<style scoped>

</style>