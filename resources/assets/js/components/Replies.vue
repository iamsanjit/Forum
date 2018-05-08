<template>
    <div>
        <div v-for="(reply, key) in items" :key="key"> 
            <reply :data="reply" @deleted="destroy(index)"></reply>
        </div>
    </div>
</template>

<script>
    import Reply from "./Reply.vue";

    export default {

        props: ['data'],

        components:{Reply},

        data() {
            return {
                items: this.data
            }
        },

        methods: {
            destroy(index) {
                this.items.splice(index, 1);
                this.$emit('removed');
            }
        }
    }
</script>