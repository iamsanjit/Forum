<template>
    <div class="alert alert-success alert-custom" role="alert" v-show="show">
            <strong>Success!</strong> {{ body }}
    </div>
</template>

<script>
    export default {

        props: ['message'],

        data() {
            return {
                body: this.message,
                show: false
            };
        },

        created() {
            if (this.message) {
                this.flash(this.message);
            }

            window.events.$on('flash',  message => this.flash(message) );
        },

        methods: {
            flash(message) {
                this.show = true;
                this.body = message;

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }

        }
    }
</script>

<style>
    .alert-custom {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>
