<template>
    <div>
        <div class="box">

            <div class="button-list">
                <button class="half gray disabled">
                    <i class="fas fa-upload"></i>
                    <span>Studenten importieren</span>
                </button>
                <router-link to="/student/create" tag="button" class="half">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Student hinzufügen</span>
                </router-link>
            </div>

            <Alert type="error" title="Fehler" message="Student konnte nicht gelöscht werden." v-if="error"/>
            <Alert type="success" title="Gelöscht" message="Student wurde erfolgreich gelöscht." v-if="success"/>
            <Alert type="info" title="Information" message="Studenten werden geladen." v-if="loading"/>
            
            <div v-else>
                <div class="alert info" v-if="students.length === 0">
                    <h1>Information</h1>
                    <p>Es exestieren derzeit keine Studenten.</p>
                </div>
                <div class="table" v-else>
                    <h1>Studenten</h1>
                    <div class="search">
                        <i class="fas fa-search fa-xs"></i>
                        <input type="text" placeholder="Suche" aria-label="Suche" v-model="search">
                    </div>
                    <div class="scroll">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="sort" @click="orderBy('surname')" v-bind:class="[
                                        { up: orderByColumn == 'surname' && orderByAsc == true },
                                        { down: orderByColumn == 'surname' && orderByAsc == false }
                                        ]">
                                        <a>
                                            <span>Nachname</span>
                                        </a>
                                    </th>
                                    <th class="sort" @click="orderBy('first_name')" v-bind:class="[
                                        { up: orderByColumn == 'first_name' && orderByAsc == true },
                                        { down: orderByColumn == 'first_name' && orderByAsc == false }
                                        ]">
                                        <a>
                                            <span>Vorname</span>
                                        </a>
                                    </th>
                                    <th class="sort" @click="orderBy('student_number')" v-bind:class="[
                                        { up: orderByColumn == 'student_number' && orderByAsc == true },
                                        { down: orderByColumn == 'student_number' && orderByAsc == false }
                                        ]">
                                        <a>
                                            <span>Matrikelnummer</span>
                                        </a>
                                    </th>
                                    <th>
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
                                <tr v-for="student in filteredStudents" :key="student.data.id">
                                    <td>
                                        <a>
                                            <span>{{ student.data.surname }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a>
                                            <span>{{ student.data.first_name }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a>
                                            <span>{{ student.data.student_number }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a>
                                            <span>{{ student.data.group ? student.data.group.data.name : '' }}</span>
                                        </a>
                                    </td>
                                    <td class="actions">
                                        <router-link :to="'/student/' + student.data.id + '/edit'">
                                            <i class="fas fa-pencil-alt"></i>
                                            <span>Bearbeiten</span>
                                        </router-link>
                                        <a @click="destroy(student)">
                                            <i class="far fa-trash-alt"></i>
                                            <span>Löschen</span>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            
                <div class="button-list" v-if="students.length >= 10">
                    <button class="half gray disabled">
                        <i class="fas fa-upload"></i>
                        <span>Studenten importieren</span>
                    </button>
                    <router-link to="/student/create" tag="button" class="half">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Student hinzufügen</span>
                    </router-link>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import Alert from '../components/Alert';
    export default {
        name: "Student",

        components: {
            Alert
        },

        mounted() {
            axios.get('/api/student')
                .then(response => {
                    this.students = response.data.data;
                    this.loading = false;
                })
                .catch(errors => {
                    this.loading = false;
                });
        },

        data: function() {
            return {
                loading: true,
                students: null,
                success: false,
                error: false,
                search: '',
                orderByColumn: 'surname',
                orderByAsc: true,
            }
        },

        methods: {
            destroy: function(student) {
                axios.delete('/api/student/' + student.data.id)
                    .then(response => {
                        if(response.status === 204) {
                            this.success = true;
                            this.error = false;
                            this.students.splice(this.students.indexOf(student), 1);
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
            filteredStudents: function() {
                return _.orderBy(this.students.filter((student) => {
                    return (
                        student.data.surname.toLowerCase().match(this.search.toLowerCase()) ||
                        student.data.first_name.toLowerCase().match(this.search.toLowerCase()) ||
                        student.data.student_number.toString().match(this.search) ||
                        (student.data.group && student.data.group.data.name.toLowerCase().match(this.search.toLowerCase()))
                    );
                }), 'data.' + this.orderByColumn, (this.orderByAsc ? 'asc' : 'desc'));
            }
        }
    }
</script>

<style scoped>

</style>