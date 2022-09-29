<template>
    <div>
        <div :class="setGoalClasses(goal, goalIndex)">
            <div class="row no-gutters align-items-center">
                <div class="col-auto">
                    <div class="goal__handle">
                        <font-awesome-icon :icon="['fas', 'grip-lines']"></font-awesome-icon>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="goal__check-container">
                        <font-awesome-icon
                            class="goal__check"
                            :icon="['far', 'square']"
                            v-show="!(goal.is_completed)"
                            @click="goalCompletionToggle"
                            v-tooltip:bottom="'Mark goal complete'">
                        </font-awesome-icon>
                        <font-awesome-icon
                            class="goal__check"
                            :icon="['far', 'check-square']"
                            v-show="goal.is_completed"
                            @click="goalCompletionToggle"
                            v-tooltip:bottom="'Mark goal incomplete'">
                        </font-awesome-icon>
                    </div>
                </div>
                <div class="col">
                    <p class="goal__name" contenteditable="true"
                    @keydown="keydownHandler($event)"
                    @keyup="keyupHandler"
                    v-mediumJsGoal></p>
                </div>
                <div class="col-auto">
                    <div class="goal__datepicker">
                        <flat-pickr
                            v-model="goal.due_date"
                            :config="{wrap: true, dateFormat: 'Y-m-d', altInput: true, altFormat: 'F j, Y'}"
                            @on-change="newOrUpdated(goal)">
                        </flat-pickr>
                        <a class="goal__datepicker-add" v-show="!(goal.due_date)" @click.prevent href="#" data-toggle>
                            <font-awesome-icon
                                :icon="['far', 'calendar']"
                                v-tooltip:bottom="'Add due date'">
                            </font-awesome-icon>
                        </a>
                        <a class="goal__datepicker-remove" v-show="goal.due_date" @click.prevent href="#" data-clear>
                            <font-awesome-icon
                                :icon="['fas', 'times']"
                                v-tooltip:bottom="'Remove due date'">
                            </font-awesome-icon>
                        </a>
                    </div>
                </div>
                <div class="col-auto">
                    <a class="goal__tasks-toggle" data-toggle="collapse" :href="'#collapse-' + goal.uid">
                        <font-awesome-icon
                            :icon="['fas', 'list']"
                            v-tooltip:bottom="'Tasks'">
                        </font-awesome-icon>
                    </a>
                </div>
                <div class="col-auto">
                    <div class="dropdown">
                        <a class="goal__more-actions" href="#" id="goalMoreActions" data-toggle="dropdown">
                            <font-awesome-icon
                                :icon="['fas', 'ellipsis-h']"
                                v-tooltip:bottom="'More actions'">
                            </font-awesome-icon>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Add task</a>
                            <a class="dropdown-item" href="#">Add goal</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="#">Delete goal</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- TASKS CONTAINER -->
        <div :id="'collapse-' + goal.uid" class="tasks__container collapse">
            <!-- TASK -->
            <draggable
            v-model="tasks"
            group="tasks"
            handle=".task__handle"
            animation="150"
            @update="updateTaskOrder(goal)"
            @remove="updateTaskOrder(goal)"
            @add="updateTaskGoalId($event, goal)">
                <task :class="setTaskClasses(task, taskIndex)" v-for="(task, taskIndex) in tasks" :key="task.uid" :task="task" :task-index="taskIndex" :goal-uid="goal.uid"></task>
            </draggable>
            <!-- END TASK -->
        </div>
        <!-- END TASKS CONTAINER -->
    </div>



    
</template>
<script>
    export default {
        props: {
            goal: Object,
            goalIndex: Number,
        },
        mounted() {
            this.$el.querySelector('.goal__name').innerText = this.goal.name;
        },
        methods: {
            setGoalClasses(goal, goalIndex) {
                let goalClasses = {};
                goalClasses['goal'] = true;
                goalClasses['goal-' + goalIndex] = true;
                goalClasses['goal-is-completed'] = goal.is_completed;
                return goalClasses;
            },
            setTaskClasses(task, taskIndex) {
                let taskClasses = {};
                taskClasses['task'] = true;
                taskClasses['task-' + taskIndex] = true;
                taskClasses['task-is-completed'] = task.is_completed;
                return taskClasses;
            },
            keydownHandler(event) {
                if(event.key == 'Enter') {
                    this.addGoalFromGoal();
                }
            },
            keyupHandler() {
                this.updateGoalName();
            },
            updateGoalName() {
                this.$store.commit('updateGoalName', {
                    goal_name: this.$el.querySelector('.goal__name').innerText,
                    goal_uid: this.goal.uid,
                })
            },
            updateTaskOrder() {

            },
            updateTaskGoalId() {

            },
            goalCompletionToggle() {
                this.goal.is_completed ? this.$store.commit('updateGoalCompletion', {uid: this.goal.uid, is_completed: false}) : this.$store.commit('updateGoalCompletion', {uid: this.goal.uid, is_completed: true});
            },
            // addGoalFromGoal(eventTarget, goalIndex, goalCategory) {
            //     console.log(eventTarget);
            //     console.log(goalIndex);
            //     console.log(goalCategory);
            //     if(goalCategory) {
            //         goalCategory.goals.splice(goalIndex + 1, 0, {
            //             'id': null,
            //             'name': '',
            //             'goal_category_id': goalCategory.id,
            //             'is_completed': false,
            //             'order': goalIndex + 1,
            //             'tasks': [],
            //             'uniqueId': _.uniqueId(),
            //             // 'newOrUpdated': true
            //         });
            //     } else {
            //         this.goals.splice(goalIndex + 1, 0, {
            //             'id': null,
            //             'name': '',
            //             'goal_category_id': null,
            //             'is_completed': false,
            //             'order': goalIndex + 1,
            //             'tasks': [],
            //             'uniqueId': _.uniqueId(),
            //             // 'newOrUpdated': true
            //         });
            //     }
                
            //     this.$nextTick(() => {
            //         $(eventTarget).closest('.goal__container').next().find('.goal__name').focus();
            //     });
            // },
            addGoalFromGoal() {
                
                
                this.$nextTick(() => {
                    $(eventTarget).closest('.goal__container').next().find('.goal__name').focus();
                });
            },
        },
        computed: {
            tasks: {
                get() {
                    // Figure way to tie tasks to goal when they are created client side
                    return this.$store.state.tasks.filter(task => task.goal_id == this.goal.id).sort((a, b) => a.order - b.order);
                },
                set(tasks) {
                    // Figure way to  tie task to this goal if the goal is new and has no id
                    console.log(tasks);
                    this.$store.commit('updateTaskOrder', {
                        goal_id: this.goal.id,
                        tasks: tasks
                    });
                }
            }
        }
    }
</script>