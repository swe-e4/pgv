<template>
    <div>
        <div class="box">
            <h1>Betreuer hinzufügen</h1>
            <form @submit.prevent="submitForm">
                <InputField name="surname" label="Nachname" placeholder="Mustermann" @update:field="form.surname = $event" :errors="errors"/>
                <InputField name="first_name" label="Vorname" placeholder="Max" @update:field="form.first_name = $event" :errors="errors"/>
                <InputField name="email" label="E-Mail" placeholder="max.mustermann@example.com" @update:field="form.email = $event" :errors="errors"/>
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
                    <button class="half" type="submit">Betreuer hinzufügen</button>
                    <button class="half gray" type="reset">Abbrechen</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import InputField from '../components/InputField';
    export default {
        name: "AdviserCreate",

        components: {
            InputField
        },

        data: function() {
            return {
                form: {
                    'surname': '',
                    'first_name': '',
                    'email': '',
                },

                errors: null,
            }
        },

        methods: {
            submitForm: function() {
                axios.post('/api/adviser', this.form)
                    .then(response => {

                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            }
        }
    }
</script>

<style scoped>

</style>