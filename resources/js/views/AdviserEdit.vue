<template>
    <div>
        <div class="box">
            <h1>Betreuer bearbeiten</h1>

            <Alert type="success" title="Bearbeitet" message="Betreuer wurde erfolgreich bearbeitet." v-if="success"/>

            <form @submit.prevent="submitForm">
                <InputField name="surname" label="Nachname" placeholder="Mustermann" @update:field="form.surname = $event" :errors="errors" :data="form.surname"/>
                <InputField name="first_name" label="Vorname" placeholder="Max" @update:field="form.first_name = $event" :errors="errors" :data="form.first_name"/>
                <InputField name="email" label="E-Mail" placeholder="max.mustermann@example.com" @update:field="form.email = $event" :errors="errors" :data="form.email"/>
                
                <div class="group">
                    <label for="group">Gruppe</label>
                    <select id="group" name="group" multiple size="10" disabled>
                        <optgroup v-for="letter in ['A','B', 'C', 'D', 'E']" :key="letter" :label="letter">
                            <option v-for="i in 5" :key="i">{{ letter }}{{ i }}</option>
                        </optgroup>
                    </select>
                    <label for="group" class="description">Mehrere Gruppen können durch Drücken der Strg-Taste ausgewählt werden.</label>
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
        name: "AdviserEdit",

        components: {
            InputField,
            Alert
        },

        mounted() {
            axios.get('/api/adviser/' + this.$route.params.id)
                .then(response => {
                    this.form = response.data.data;
                })
                .catch(errors => {
                    if(errors.response.status === 404 || errors.response.status === 403) {
                        this.$router.push('/adviser');
                    }
                });
        },

        data: function() {
            return {
                form: {
                    'surname': '',
                    'first_name': '',
                    'email': '',
                },
                success: false,
                errors: null,
            }
        },

        methods: {
            submitForm: function() {
                axios.patch('/api/adviser/' + this.$route.params.id, this.form)
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