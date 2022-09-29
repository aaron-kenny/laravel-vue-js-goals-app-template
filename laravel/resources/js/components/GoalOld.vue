<template>
    <p class="goal__name" contenteditable="true"
    @keyup="keyupHandler($event)"
    v-mediumJsGoal></p>
</template>
<script>
    export default {
        props: {
            goal: Object,
            goalIndex: Number,
        },
        data() {
            return {
                characterLimit: 15,
            }
        },
        mounted() {
            this.$el.innerText = this.goal.name;
        },
        methods: {
            keyupHandler(event){
                this.updateGoalName();
            },
            updateGoalName() {
                this.$store.commit('updateGoalName', {
                    name: this.$el.innerText,
                    index: this.goalIndex,
                })
            },
        },
    }
</script>