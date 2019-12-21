<template>
    <div>
        <div class="box">
            <h1>Gruppe hinzufügen</h1>

            <div>
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
                                <option v-for="adviser in advisers" :key="adviser.data.id" v-bind:value="adviser.data.id">{{ adviser.data.full_name }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="button-list">
                        <button class="half" type="submit">Gruppe hinzufügen</button>
                        <button class="half gray" type="reset" @click="$router.back();">Abbrechen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import InputField from '../components/InputField';
    import Alert from '../components/Alert';
    export default {
        name: "GroupCreate",

        components: {
            InputField,
            Alert
        },
        
        mounted() {
            axios.get('/api/adviser')
                .then(response => {
                    this.advisers = _.orderBy(response.data.data, 'data.full_name');
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
                    'adviser_id': null
                },
                success: false,
                errors: null,
                loading: true,
                advisers: null,
            }
        },

        methods: {
            submitForm: function() {
                axios.post('/api/group', this.form)
                    .then(response => {
                        this.success = true;
                        this.form = {
                                'name': '',
                                'adviser_id': null
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