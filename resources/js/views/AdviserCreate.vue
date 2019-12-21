<template>
    <div>
        <div class="box">
            <h1>Betreuer hinzufügen</h1>

            <Alert type="success" title="Hinzugefügt" message="Betreuer wurde erfolgreich hinzugefügt." v-if="success"/>
            
            <form @submit.prevent="submitForm">
                <InputField name="surname" label="Nachname" placeholder="Mustermann" @update:field="form.surname = $event" :errors="errors" :data="form.surname"/>
                <InputField name="first_name" label="Vorname" placeholder="Max" @update:field="form.first_name = $event" :errors="errors" :data="form.first_name"/>
                <InputField name="email" label="E-Mail" placeholder="max.mustermann@example.com" @update:field="form.email = $event" :errors="errors" :data="form.email"/>
        
                <div class="group">
                    <label for="groups">Gruppen</label>

                    <Alert type="info" title="Information" message="Gruppen werden geladen." v-if="loading"/>
                        
                    <div v-else>

                        <div class="alert info" v-if="groups.length === 0">
                            <h1>Information</h1>
                            <p>Es exestieren derzeit keine Gruppen.</p>
                        </div>

                        <select id="groups" name="groups[]" v-else v-model="form.groups" multiple size="10">
                            <option v-for="group in groups" :key="group.data.id" v-bind:value="group.data.id">{{ group.data.name }}</option>
                        </select>

                        <label for="group" class="description">Mehrere Gruppen können durch Drücken der Strg-Taste ausgewählt werden. Gruppen können mit dem Drücken Strg-Taste und einem erneuten Klick auf diese, abgewählt werden.</label>
                    </div>
                </div>

                <div class="button-list">
                    <button class="half" type="submit">Betreuer hinzufügen</button>
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
        name: "AdviserCreate",

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
                    'surname': '',
                    'first_name': '',
                    'email': '',
                    'groups': [],
                },
                success: false,
                errors: null,
                loading: true,
                groups: null,
            }
        },

        methods: {
            submitForm: function() {
                axios.post('/api/adviser', this.form)
                    .then(response => {
                        this.success = true;
                        this.form = {
                                'surname': '',
                                'first_name': '',
                                'email': '',
                                'groups': [],
                            };
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