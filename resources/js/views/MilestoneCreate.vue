<template>
    <div>
        <div class="box">
            <h1>Meilenstein hinzufügen</h1>

            <Alert type="success" title="Hinzugefügt" message="Meilenstein wurde erfolgreich hinzugefügt." v-if="success"/>
            
            <form @submit.prevent="submitForm">
                
                <div class="group">
                    <label for="group">Fälligkeitsdatum</label>
                    <datetime v-model="form.deadline" placeholder="Fälligkeitsdatum" format="yyyy-MM-dd" auto></datetime>
                </div>

                <InputField name="name" label="Name" placeholder="Name" @update:field="form.name = $event" :errors="errors" :data="form.name"/>

                <div class="button-list">
                    <button class="half" type="submit">Meilenstein hinzufügen</button>
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
        name: "MilestoneCreate",

        components: {
            InputField,
            Alert
        },

        data: function() {
            return {
                form: {
                    'name': '',
                    'deadline': ''
                },
                success: false,
                errors: null,
                loading: true,
            }
        },

        methods: {
            submitForm: function() {
                this.form.deadline = this.form.deadline.split("T00:00:00.000Z")[0];
                axios.post('/api/milestone', this.form)
                    .then(response => {
                        this.success = true;
                        this.form = {
                                'name': '',
                                'deadline': ''
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