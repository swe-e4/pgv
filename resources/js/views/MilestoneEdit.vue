<template>
    <div>
        <div class="box">
            <h1>Meilenstein bearbeiten</h1>

            <Alert type="success" title="Bearbeitet" message="Meilenstein wurde erfolgreich bearbeitet." v-if="success"/>
            
            <form @submit.prevent="submitForm">
                
                <div class="group">
                    <label for="group">Fälligkeitsdatum</label>
                    <datetime v-model="form.deadline" placeholder="Fälligkeitsdatum" format="yyyy-MM-dd" auto></datetime>
                </div>

                <InputField name="name" label="Name" placeholder="Name" @update:field="form.name = $event" :errors="errors" :data="form.name"/>

                <div class="button-list">
                    <button class="half" type="submit">Meilenstein bearbeiten</button>
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
        name: "MilestoneEdit",

        components: {
            InputField,
            Alert
        },

        mounted() {
            axios.get('/api/milestone/' + this.$route.params.id)
                .then(response => {
                    this.form = response.data.data;
                })
                .catch(errors => {
                    if(errors.response.status === 404 || errors.response.status === 403) {
                        this.$router.push('/milestone');
                    }
                });
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
                axios.patch('/api/milestone/' + this.$route.params.id, this.form)
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