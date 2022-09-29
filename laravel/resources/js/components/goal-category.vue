<template>
    <div>
        <h2 class="goal-category__name"
        ref="goalCategoryName"
        contenteditable="true"
        @input="updateName($event)"></h2>
        <p class="goal-category__description"
        ref="goalCategoryDescription"
        v-show="description"
        contenteditable="true"
        @input="updateDescription($event)"></p>
    </div>
</template>
<script>
    export default {
        props: ['name', 'description'],
        mounted() {
            this.$refs.goalCategoryName.innerText = this.name;
            this.$refs.goalCategoryDescription.innerText = this.description;
        },
        methods: {
            updateName(event){
                this.$emit('update:name', event.target.innerText);
            },
            updateDescription(event){
                this.$emit('update:description', event.target.innerText);
            },
        }
    }
</script>