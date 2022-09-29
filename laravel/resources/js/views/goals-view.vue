<template>
    <div class="container">

        <div class="section__header" style="border-bottom: 2px solid rgba(255, 255, 255, 0.05); padding-bottom: 10px; margin-bottom: 20px;">
            <div class="row align-items-center">
                <div class="col">
                    <h1>Goals</h1>
                </div>
                <div class="col-auto">
                    <a class="btn" href="#"><font-awesome-icon :icon="['fas', 'filter']"></font-awesome-icon> Filter</a>
                </div>
                <div class="col-auto">
                    <div class="dropdown">
                        <a class="btn btn-primary btn-sm dropdown-toggle" href="#" id="goalsActions" data-toggle="dropdown">Actions</a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#" @click.prevent="addCategory">Add category</a>
                            <a class="dropdown-item" href="#" @click.prevent="addCategory">Add goal</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="#" @click.prevent="addCategory">Delete all</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="error" v-if="error">
            {{ error }}
        </div>
        <div v-if="loading">
            <goal-placeholder></goal-placeholder>
            <goal-placeholder></goal-placeholder>
            <goal-placeholder></goal-placeholder>
            <goal-placeholder></goal-placeholder>
            <goal-placeholder></goal-placeholder>
        </div>

        <!-- GOALS WITHOUT CATEGORY -->
        <draggable v-model="goalsWithoutCategory" group="goals" handle=".goal__handle" animation="150" @add="updateGoalCategoryId($event)">
            <goal class="goal__container" v-for="(goal, goalIndex) in goalsWithoutCategory" :key="goal.uniqueId" :goal="goal" :goal-index="goalIndex"></goal>
        </draggable>
        <!-- END GOALS WITHOUT CATEGORY -->
                
            <!-- GOAL CATEGORY -->
            <draggable
            v-model="goalCategories"
            handle=".goal-category__handle"
            animation="150"
            @update="updateGoalCategoryOrder"
            @remove="updateGoalCategoryOrder"
            @add="updateGoalCategoryOrder">
                <div class="goal-category__container" v-for="(goalCategory, goalCategoryIndex) in goalCategories" :key="goalCategory.uniqueId">
                        <div :class="setGoalCategoryClasses(goalCategory, goalCategoryIndex)">
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="goal-category__handle">
                                        <font-awesome-icon :icon="['fas', 'grip-lines']"></font-awesome-icon>
                                    </div>
                                </div>
                                <div class="col">
                                    <goal-category
                                        :name.sync="goalCategory.name"
                                        :description.sync="goalCategory.description"
                                        @keydown.enter.native.prevent="addGoalFromGoal($event, goalIndex, goalCategory)"
                                        @keydown.tab.native.prevent="addTaskFromGoal($event, goal)"
                                        @keydown.8.native="deleteGoalCategory($event, goalCategory, goalCategoryIndex)">
                                    </goal-category>
                                </div>
                                <div class="col-auto">
                                    <div class="dropdown">
                                        <a class="goal-category__more-actions" href="#" id="goalCategoryMoreActions" data-toggle="dropdown">
                                            <font-awesome-icon
                                                :icon="['fas', 'ellipsis-h']"
                                                v-tooltip:bottom="'More actions'">
                                            </font-awesome-icon>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Add category</a>
                                            <a class="dropdown-item" href="#">Add sub goal</a>
                                            <a class="dropdown-item" href="#">Add description</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger" href="#">Delete category</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- GOAL -->
                        <draggable
                        v-model="goalCategory.goals"
                        group="goals"
                        handle=".goal__handle"
                        animation="150"
                        @update="updateGoalOrder(goalCategory)"
                        @remove="updateGoalOrder(goalCategory)"
                        @add="updateGoalCategoryId($event, goalCategory)">
                            <div class="goal__container" v-for="(goal, goalIndex) in goalCategory.goals" :key="goal.uniqueId">
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
                                                        @click="goalCompletionToggle(goal)"
                                                        v-tooltip:bottom="'Mark goal complete'">
                                                    </font-awesome-icon>
                                                    <font-awesome-icon
                                                        class="goal__check"
                                                        :icon="['far', 'check-square']"
                                                        v-show="goal.is_completed"
                                                        @click="goalCompletionToggle(goal)"
                                                        v-tooltip:bottom="'Mark goal incomplete'">
                                                    </font-awesome-icon>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <goal
                                                    :name.sync="goal.name"
                                                    @keydown.enter.native.prevent="addGoalFromGoal($event, goalIndex, goalCategory)"
                                                    @keydown.tab.native.prevent="addTaskFromGoal($event, goal)"
                                                    @keydown.8.native="deleteGoal($event, goal, goalIndex, goalCategory)">
                                                </goal>
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
                                                <a class="goal__tasks-toggle" data-toggle="collapse" :href="'#collapse-' + goal.uniqueId">
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
                                                        <a class="dropdown-item" href="#">Delete goal</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- TASKS CONTAINER -->
                                    <div :id="'collapse-' + goal.uniqueId" class="tasks__container collapse">
                                            <!-- TASK -->
                                            <draggable
                                            v-model="goal.tasks"
                                            group="tasks"
                                            handle=".task__handle"
                                            animation="150"
                                            @update="updateTaskOrder(goal)"
                                            @remove="updateTaskOrder(goal)"
                                            @add="updateTaskGoalId($event, goal)">
                                                <div :class="setTaskClasses(task, taskIndex)" v-for="(task, taskIndex) in goal.tasks" :key="task.uniqueId">
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
                                                                    @click="taskCompletionToggle(goal, task)"
                                                                    v-tooltip:bottom="'Mark task complete'">
                                                                </font-awesome-icon>
                                                                <font-awesome-icon
                                                                    class="task__check"
                                                                    :icon="['far', 'check-square']"
                                                                    v-show="task.is_completed"
                                                                    @click="taskCompletionToggle(goal, task)"
                                                                    v-tooltip:bottom="'Mark task incomplete'">
                                                                </font-awesome-icon>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <Task
                                                                :name.sync="task.name"
                                                                @keydown.enter.native.prevent="addTaskFromTask($event, taskIndex, goal)"
                                                                @keydown.8.native="deleteTask($event, task, taskIndex, goal)">
                                                            </Task>
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
                                                </div>
                                            </draggable>
                                            <!-- END TASK -->
                                    </div>
                                    <!-- END TASKS CONTAINER -->
                            </div>
                        </draggable>
                        <!-- END GOAL -->
                </div>
            </draggable>
            <!-- END GOAL CATEGORY -->

        <v-tour name="goalsTour" :steps="steps"></v-tour>
    </div>
</template>
<script>
    import { mapActions } from 'vuex';

    export default {
        data() {
            return {
                loading: true,
                error: null,
                deletedIds: {
                    goalCategoryIds: [],
                    goalIds: [],
                    taskIds: [],
                },
                steps: [
                    {
                        target: '#dropdownMenuLink',
                        content: 'Hey this is the start of the tour',
                    },
                    {
                        target: '#goalsActions',
                        content: 'Add goals or categories here.',
                    }
                ]
            }
        },
        created() {
            this.getAllGoals();
        },
        mounted() {
            this.$tours['goalsTour'].start();
        },
        methods: {
            ...mapActions([
                'getAllGoals',
            ]),
            setGoalCategoryClasses(goalCategory, goalCategoryIndex) {
                let goalCategoryClasses = {};
                goalCategoryClasses['goal-category'] = true;
                goalCategoryClasses['goal-category-' + goalCategoryIndex] = true;
                return goalCategoryClasses;
            },
            
            goalCompletionToggle(goal) {
                goal.is_completed ? this.$set(goal, 'is_completed', false) : this.$set(goal, 'is_completed', true);
                goal.newOrUpdated = true;
                // this.finishedInput();
            },
            taskCompletionToggle(goal, task) {
                task.is_completed ? this.$set(task, 'is_completed', false) : this.$set(task, 'is_completed', true);
                goal.newOrUpdated = true;
                // this.finishedInput();
            },
            updateGoalCategoryOrder() {
                this.goalCategories.map((goalCategory, index) => {
                    return goalCategory.order = index;
                });
            },
            updateGoalOrder(goalCategory) {
                goalCategory.goals.map((goal, index) => {
                    return goal.order = index;
                });
            },
            // updateTaskOrder(goal) {
            //     goal.tasks.map((task, index) => {
            //         return task.order = index;
            //     });
            // },
            updateTaskOrder(goal) {
                // console.log(goal);
                // this.$store.commit('updateGoalOrder', goal);
            },
            updateGoalCategoryId(event, goalCategory) {
                if(goalCategory == 'undefined') {
                    console.log('goal category undefined');
                    // this.goals[event.newIndex].goal_category_id = null;
                    this.$store.commit('updateGoalCategoryId', {
                        goalCategoryId: null,
                        goalIndex: event.newIndex,
                    });
                } else {
                    console.log('goal category defined');
                    // goalCategory.goals[event.newIndex].goal_category_id = goalCategory.id;
                    this.$store.commit('updateGoalCategoryId', {
                        goalCategoryId: goalCategory.id,
                        goalIndex: event.newIndex,
                    });
                }
            },
            updateGoalCategoryIdNC(event) {
                this.goals[event.newIndex].goal_category_id = null;

            },
            updateTaskGoalId(event, goal) {
                goal.tasks[event.newIndex].goal_id = goal.id;
                this.updateTaskOrder(goal);
            },
            newOrUpdated(item) {
                item.newOrUpdated = true;
            },

            





            
            
            addTaskFromGoal(event, goal) {
                goal.tasks.unshift({
                    'id': null,
                    'name': '',
                    'goal_id': goal.id,
                    'is_completed': false,
                    'order': 0,
                    'uniqueId': _.uniqueId(),
                });
                this.updateTaskOrder(goal);
                
                // Mark parent goal as updated
                // goal.newOrUpdated = true;
                
                // Show tasks container and focus on the newly created element after DOM is updated
                this.$nextTick(() => {
                    $(event.target).closest('.goal__container').find('.tasks__container').collapse('show');
                    $(event.target).closest('.goal__container').find('.task__name').first().focus();
                });
            },
            deleteGoalCategory(event, goalCategory, goalCategoryIndex) {
                console.log('deleteGoalCategory method ran');
                
                if(event.target.innerText == 0) {
                    // Prevent deleting
                    event.preventDefault();

                    // Get previous element
                    let previousElement = $(event.target).closest('.goal-category__container').prev().find('.goal-category__name').get(0);

                    // If there's a previous element focus on
                    // it and put the cursor at the end
                    if (previousElement !== undefined){
                        previousElement.focus();
                        
                        let range,selection;
                        //Firefox, Chrome, Opera, Safari, IE 9+
                        if(document.createRange){
                            range = document.createRange();
                            range.selectNodeContents(previousElement);
                            range.collapse(false);
                            selection = window.getSelection();
                            selection.removeAllRanges();
                            selection.addRange(range);
                        }
                        //IE 8 and lower
                        else if(document.selection){
                            range = document.body.createTextRange();
                            range.moveToElementText(previousElement);
                            range.collapse(false);
                            range.select();
                        }
                    }

                    
                    if(goalCategory.id !== null){
                        this.deletedIds.goalCategoryIds.push(goalCategory.id);
                    }
                    let goalIds = goalCategory.goals.map(goal => {
                        let taskIds = goal.tasks.map(task => {
                            if(task.id !== null){return task.id;}
                        });
                        Array.prototype.push.apply(this.deletedIds.taskIds, taskIds);
                        return (goal.id !== null) ? goal.id : '';
                    });
                    console.log(goalIds);
                    Array.prototype.push.apply(this.deletedIds.goalIds, goalIds);

                    // Remove specific goal from local data (Also deletes tasks under it)
                    this.$delete(this.goalCategories, goalCategoryIndex);
                    this.updateGoalCategoryOrder();
                }
            },
            deleteGoal(event, goal, goalIndex, goalCategory) {
                console.log('deleteGoal method ran');
                
                if(event.target.innerText == 0) {
                    // Prevent deleting
                    event.preventDefault();

                    // Get previous element
                    let previousElement = $(event.target).closest('.goal__container').prev().find('.goal__name').get(0);

                    // If there's a previous element focus on
                    // it and put the cursor at the end
                    if (previousElement !== undefined) {
                        previousElement.focus();
                        
                        let range,selection;
                        //Firefox, Chrome, Opera, Safari, IE 9+
                        if(document.createRange) {
                            range = document.createRange();
                            range.selectNodeContents(previousElement);
                            range.collapse(false);
                            selection = window.getSelection();
                            selection.removeAllRanges();
                            selection.addRange(range);
                        }
                        //IE 8 and lower
                        else if(document.selection) {
                            range = document.body.createTextRange();
                            range.moveToElementText(previousElement);
                            range.collapse(false);
                            range.select();
                        }
                    }

                    
                    if(goal.id !== null) {
                        this.deletedIds.goalIds.push(goal.id);
                    }
                    let taskIds = goal.tasks.filter(task => task.id !== null).map(task => task.id);
                    Array.prototype.push.apply(this.deletedIds.taskIds, taskIds);

                    // Remove specific goal from local data (Also deletes tasks under it)
                    this.$delete(goalCategory.goals, goalIndex);
                    this.updateGoalOrder(goalCategory);
                }
            },
            deleteTask(event, task, taskIndex, goal) {
                console.log('deleteTask method ran');
                
                if(event.target.innerText == 0) {
                    // Prevent deleting
                    event.preventDefault();

                    // Get previous element
                    let previousElement = $(event.target).closest('.task').prev().find('.task__name').get(0);

                    // If there's a previous element focus on
                    // it and put the cursor at the end
                    if (previousElement !== undefined) {
                        previousElement.focus();
                        
                        let range,selection;
                        //Firefox, Chrome, Opera, Safari, IE 9+
                        if(document.createRange) {
                            range = document.createRange();
                            range.selectNodeContents(previousElement);
                            range.collapse(false);
                            selection = window.getSelection();
                            selection.removeAllRanges();
                            selection.addRange(range);
                        }
                        //IE 8 and lower
                        else if(document.selection) {
                            range = document.body.createTextRange();
                            range.moveToElementText(previousElement);
                            range.collapse(false);
                            range.select();
                        }
                    }

                    
                    if(task.id !== null) {
                        this.deletedIds.taskIds.push(task.id);
                    }
                    // let taskIds = goal.tasks.filter(task => task.id !== null).map(task => task.id);
                    // Array.prototype.push.apply(this.deletedIds.taskIds, taskIds);

                    // Remove specific goal from local data (Also deletes tasks under it)
                    this.$delete(goal.tasks, taskIndex);
                    this.updateTaskOrder(goal);
                }
            },
        },
        computed: {
            goals: {
                get() {
                    return this.$store.state.goals;
                },
                set(goals) {
                    console.log('computed setter ran');
                    console.log(goals);
                    this.$store.commit('updateGoalOrder', goals);
                }
            },
            goalsWithoutCategory: {
                get() {
                    return this.$store.state.goals.filter(goal => goal.goal_category_id == null).sort((a, b) => a.order - b.order).map(goal => {
                        let tasks = this.$store.state.tasks.filter(task => task.goal_id == goal.id);
                        goal.tasks = tasks;
                        this.loading = false;
                        return goal;
                    });
                },
                set(goals) {
                    // Set order according to index
                    console.log('computed setter ran');
                    console.log(goals);
                    this.$store.commit('updateGoalOrder', goals);
                }
            },
        }
    }
</script>
