<template>
    <div>
        <div class="box">
            <Alert type="error" title="Fehler" message="Das Passwort ist mit dem alten Passwort identisch." v-if="same_as_old"/>
            <Alert type="error" title="Fehler" message="Das angegebene Passwort ist falsch." v-if="wrong_pw"/>
            <Alert type="success" title="Erfolgreich" message="Das Passwort wurde erfolgreich geändert." v-if="success"/>
            
            <h1>Passwort ändern</h1>
            <form @submit.prevent="submitForm">
                <InputField name="password" label="Aktuelles Passwort" placeholder="********" @update:field="form.password = $event" :errors="errors" :data="form.password"/>
                <InputField name="passwordNew" label="Neues Passwort" placeholder="********" @update:field="form.passwordNew = $event" :errors="errors" :data="form.passwordNew"/>
                <InputField name="passwordNewRepeat" label="Neues Passwort wiederholen" placeholder="********" @update:field="form.passwordNewRepeat = $event" :errors="errors" :data="form.passwordNewRepeat"/>

                <div class="button-list">
                    <button class="half" type="submit">Änderung speichern</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import InputField from '../components/InputField';
    import Alert from '../components/Alert';
    export default {
        name: "Settings",

        components: {
            Alert,
            InputField
        },

        data: function() {
            return {
                'form': {
                    'password': '',
                    'passwordNew': '',
                    'passwordNewRepeat': '',
                },
                'errors': null,
                'same_as_old': false,
                'wrong_pw': false,
                'success': false,
            }
        },

        methods: {
            submitForm: function() {
                axios.post('/api/changepassword', this.form)
                    .then(response => {
                        this.success = true;
                        this.form = {
                                'password': '',
                                'passwordNew': '',
                                'passwordNewRepeat': '',
                            };
                        if(response.data == 'same_as_old') {
                            this.same_as_old = true;
                        } else {
                            this.same_as_old = false;
                        }
                        if(response.data == 'wrong_pw') {
                            this.wrong_pw = true;
                        } else {
                            this.wrong_pw = false;
                        }
                        if(!this.wrong_pw && !this.same_as_old) {
                            this.success = true;
                        } else {
                            this.success = false;
                        }
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