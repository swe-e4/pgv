<template>
    <div class="group">
        <label :for="name">{{ label }}</label>
        <input type="text" :id="name" :class="errorClassObject()" :placeholder="placeholder" v-model="value" @input="updateField()">
    
        <p class="error" v-text="errorMessage()">Fehler</p>
    </div>
</template>

<script>
    export default {
        name: "InputField",

        props: [
            'name',
            'label',
            'placeholder',
            'errors',
        ],

        data: function() {
            return {
                value: ''
            }
        },

        computed: {
            hasError: function() {
                return this.errors && this.errors[this.name] && this.errors[this.name].length > 0;
            }
        },

        methods: {
            updateField: function() {
                this.clearErrors(this.name);

                this.$emit('update:field', this.value)
            },
            errorMessage: function() {
                if(this.hasError) {
                    return this.errors[this.name][0];
                }
            },
            clearErrors: function() {
                if(this.hasError) {
                    this.errors[this.name] = null;
                }
            },
            errorClassObject: function() {
                return {
                    'error': this.hasError
                }
            }
        }
    }
</script>

<style scoped>

</style>