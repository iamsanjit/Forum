<template>
    <button type="submit" :class="classes" @click="toggle">
        <span v-text="count"></span>
        <span class="glyphicon glyphicon-heart"></span>
    </button>
</template>

<script>
    export default {
        props: ['reply'],

        data() {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited
            }
        },

        computed: {
            classes() {
                return ['btn', this.active ? 'btn-primary' : 'btn-default'];
            },

            endpoint() {
                return '/replies/' + this.reply.id + '/favorites';
            }
        },

        methods: {
            toggle() {
                return this.active ? this.destroy() : this.create();
            },

            destroy() {
                axios.delete(this.endpoint);
                this.active = false;
                this.count--;
            },

            create() {
                axios.post(this.endpoint);                    
                this.active = true;
                this.count++;
            }
        },
    }
</script>