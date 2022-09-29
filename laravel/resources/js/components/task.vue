<template>
    <div class="row no-gutters align-items-center">
        <div class="col-auto">
            <div class="task__handle">
                <font-awesome-icon :icon="['fas', 'grip-lines']"></font-awesome-icon>
            </div>
        </div>
        <div class="col-auto">
            <div class="task__check-container">
                <font-awesome-icon
                    class="task__check"
                    :icon="['far', 'square']"
                    v-show="!(task.is_completed)"
                    @click="taskCompletionToggle"
                    v-tooltip:bottom="'Mark task complete'">
                </font-awesome-icon>
                <font-awesome-icon
                    class="task__check"
                    :icon="['far', 'check-square']"
                    v-show="task.is_completed"
                    @click="taskCompletionToggle"
                    v-tooltip:bottom="'Mark task incomplete'">
                </font-awesome-icon>
            </div>
        </div>
        <div class="col">
            <!-- <Task
                :name.sync="task.name"
                @keydown.enter.native.prevent="addTaskFromTask($event, taskIndex, goal)"
                @keydown.8.native="deleteTask($event, task, taskIndex, goal)">
            </Task> -->
            <p class="task__name" contenteditable="true"
            @keydown="keydownHandler($event)"
            @keyup="keyupHandler"
            v-mediumJsTask></p>
        </div>
        <div class="col-auto">
            <div class="task__datepicker">
                <flat-pickr
                    v-model="task.due_date"
                    :config="{wrap: true, dateFormat: 'Y-m-d', altInput: true, altFormat: 'F j, Y'}"
                    @on-change="newOrUpdated(task)">
                </flat-pickr>
                <a class="task__datepicker-add" v-show="!(task.due_date)" @click.prevent href="#" data-toggle>
                    <font-awesome-icon
                        :icon="['far', 'calendar']"
                        v-tooltip:bottom="'Add due date'">
                    </font-awesome-icon>
                </a>
                <a class="goal__datepicker-remove" v-show="task.due_date" @click.prevent href="#" data-clear>
                    <font-awesome-icon
                        :icon="['fas', 'times']"
                        v-tooltip:bottom="'Remove due date'">
                    </font-awesome-icon>
                </a>
            </div>
        </div>
        <div class="col-auto">
            <div class="dropdown">
                <a class="task__more-actions" href="#" data-toggle="dropdown">
                    <font-awesome-icon
                        :icon="['fas', 'ellipsis-h']"
                        v-tooltip:bottom="'More actions'">
                    </font-awesome-icon>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Add task</a>
                    <a class="dropdown-item" href="#">Delete task</a>
                </div>
            </div>
        </div>
        
    </div>
</template>
<script>
    export default {
        props: {
            task: Object,
            taskIndex: Number,
            goalUid: String,
        },
        mounted() {
            this.$el.querySelector('.task__name').innerText = this.task.name;
        },
        methods: {
            keydownHandler(event) {
                if(event.key == 'Enter') {
                    this.$store.commit('addTask', {
                        goal_uid: this.goalUid,
                        task_index: this.taskIndex
                    });
                    this.$nextTick(() => {
                        $(event.target).closest('.task').next().find('.task__name').focus();
                    });
                }
            },
            keyupHandler() {
                this.updateTaskName();
            },
            updateTaskName() {
                this.$store.commit('updateTaskName', {
                    task_name: this.$el.querySelector('.task__name').innerText,
                    task_uid: this.task.uid,
                })
            },
            taskCompletionToggle() {
                this.task.is_completed ? this.$store.commit('updateTaskCompletion', {uid: this.task.uid, is_completed: false}) : this.$store.commit('updateTaskCompletion', {uid: this.task.uid, is_completed: true});
            },
        }
    }
</script>