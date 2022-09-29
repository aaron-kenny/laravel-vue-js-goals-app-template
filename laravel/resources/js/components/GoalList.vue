<template>
    <div>
        <div>
            <div>
                <div>Goals</div>
                <div class="actions">
                    <div class="dropdown actions__item">
                        <i class="fas fa-sort" data-toggle="dropdown"></i>

                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="" class="dropdown-item">Newest to Oldest</a>
                            <a href="" class="dropdown-item">Oldest to Newest</a>
                            <a href="" class="dropdown-item">Completed first</a>
                        </div>
                    </div>
                    <a href="" class="actions__item far fa-question-circle"></a>
                    <a href="" class="actions__item fas fa-cog"></a>
                    <i class="actions__item fas fa-plus" @click="addGoalStart($event, 'spiritual')" data-toggle="tooltip" title="Add goal"></i>
                </div>
            </div>
            <div>
                <!-- <div :class="setGoalClasses(goal, goalIndex)" v-for="(goal, goalIndex) in goals.spiritual" :key="goal.vueUniqueItemId"> -->
                <div :class="setGoalClasses(goal, goalIndex)" v-for="(goal, goalIndex) in goals" :key="goal.vueUniqueItemId">
                    <goal-item :goal="goal"></goal-item>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    
    // import GoalItem from './GoalItem.vue';
    
    // This function must be a const so we can easily cancel it mid-debounce
    const finishedInputConst = _.debounce(function() {
        console.log('finishedInput(debounce) method ran');
        this.goalsSave();
    }, 3000);
    
    export default {
        // components: {
        //     GoalItem
        // },
        data() {
            return {
                goals: {
                    'spiritual': [],
                    'mental': [],
                    'vocational': [],
                    'financial': [],
                    'family': [],
                    'social': [],
                    'physical': []
                },
                settings: {
                    showTasks: true
                }
            };
        },
        created() {
            this.getGoals();
        },
        mounted() {
            this.setup();
        },
        methods: {
            /*
            |--------------------------------------------------------------------------
            | setGoalClasses()
            |--------------------------------------------------------------------------
            |
            | Sets the dynamic classes on goals
            |
            */
            setGoalClasses: function(goal, goalIndex) {
                let goalClasses = {};
                goalClasses['goal'] = true;
                goalClasses['goal-' + goalIndex] = true;
                goalClasses['goal-is-completed'] = goal.is_completed;
                return goalClasses;
            },
            /*
            |--------------------------------------------------------------------------
            | setTaskClasses()
            |--------------------------------------------------------------------------
            |
            | Sets the dynamic classes on tasks
            |
            */
            setTaskClasses: function(task, taskIndex) {
                let taskClasses = {};
                taskClasses['task'] = true;
                taskClasses['task-' + taskIndex] = true;
                taskClasses['task-is-completed'] = task.is_completed;
                return taskClasses;
            },
            /*
            |--------------------------------------------------------------------------
            | getGoals()
            |--------------------------------------------------------------------------
            |
            | Get goals from Laravel controller and save them to local data
            |
            */
            getGoals: function() {
                axios.get('/api/goals').then((response) => {
                    console.log(response);
                    // If goals are in database add them to local data
                    if(response.data.length !== 0) {
                        $.each(response.data, (goalIndex, goal) => {
                            // Add unique ID so Vue can keep track
                            goal.vueUniqueItemId = Date.now() - goalIndex * 10000;
                            // Push goals into Vue data by their category
                            if(goal.category != null) {
                                this.goals[goal.category].push(goal);
                            } else {
                                this.goals.push(goal);
                            }
                            // Add unique ID to tasks so Vue can keep track
                            $.each(goal.tasks, (taskIndex, task) => {
                                task.vueUniqueItemId = Date.now() - taskIndex * 12020;
                            });
                        });
                    }
                })
                // Log any errors
                .catch((error) => {
                    console.log( error );
                });
            },
            /*
            |--------------------------------------------------------------------------
            | setup()
            |--------------------------------------------------------------------------
            |
            | Perform one time setup for the page
            |
            */
            setup: function() {
                
                //window.onbeforeunload = saveBeforeExit;
                //
                //function saveBeforeExit() {
                //    let currentElement = document.activeElement;
                //    
                //    // Blur to trigger saving text to local data
                //    currentElement.blur();
                //    
                //    // Get index of the current element
                //    let index = 0;
                //    while ((currentElement = currentElement.previousElementSibling)) {
                //        index++;
                //    }
                //    
                //    
                //    // Save goals before closing window
                //    this.goalsSave();
                //    
                //    return null;
                //}
                
                
                //window.addEventListener('beforeunload', function(event) {
                //    let currentElement = document.activeElement;
                //    
                //    // Blur to trigger saving text to local data
                //    currentElement.blur();
                //    
                //    // Get index of the current element
                //    let index = 0;
                //    while ((currentElement = currentElement.previousElementSibling)) {
                //        index++;
                //    }
                //    
                //    
                //    // Save goals before closing window
                //    this.goalsSave();
                //}, false);
                
            },
            /*
            |--------------------------------------------------------------------------
            | addGoalFromGoal()
            |--------------------------------------------------------------------------
            |
            | Creates new goal in local data and focuses on it after the DOM updates
            |
            */
            addGoalFromGoal: function(goalIndex, event, category) {
                console.log('addGoalFromGoal method ran');
                
                // Adjust order up 1 for each item after the inserted item
                for(let i = goalIndex + 1; i < this.goals[category].length; i++) {
                    this.goals[category][i].order = i + 1;
                    this.goals[category][i].newOrUpdated = true;
                }
                
                // Splice the new item in forcing Vue to update
                this.goals[category].splice(goalIndex + 1, 0, {
                    'id': null,
                    'category': category,
                    'goal': '',
                    'is_completed': false,
                    'order': goalIndex + 1,
                    'tasks': [],
                    'vueUniqueItemId': Date.now(),
                    'newOrUpdated': true
                });
                
                // Focus on the newly created element after DOM is updated
                this.$nextTick(() => {
                    $(event.target).closest('.goal').next().find('.goal__text').focus();
                });
            },
            /*
            |--------------------------------------------------------------------------
            | addGoalStart()
            |--------------------------------------------------------------------------
            |
            | Creates new goal in local data and focuses on it after the DOM updates
            |
            */
            addGoalStart: function(event, category) {
                console.log('addGoal method ran');
                
                // Adjust order up 1 for every item
                for(let i = 0; i < this.goals[category].length; i++) {
                    this.goals[category][i].order = i + 1;
                    this.goals[category][i].newOrUpdated = true;
                }
                
                // Add goal to start of array
                this.goals[category].unshift({
                    'id': null,
                    'category': category,
                    'goal': '',
                    'is_completed': false,
                    'order': 0,
                    'tasks': [],
                    'vueUniqueItemId': Date.now(),
                    'newOrUpdated': true
                });
                
                // Focus on the newly created element after DOM is updated
                this.$nextTick(() => {
                    $(event.target).closest('.card').find('.goal-text').first().focus();
                });
            },
            /*
            |--------------------------------------------------------------------------
            | addTaskFromGoal()
            |--------------------------------------------------------------------------
            |
            | Creates new task in local data and focuses on it after the DOM updates
            |
            */
            addTaskFromGoal: function(goal, event, category) {
                console.log('addTaskFromGoal method ran');
                
                // Adjust order up 1 for all items
                for(let ti = 0; ti < goal.tasks.length; ti++) {
                    goal.tasks[ti].order = ti + 1;
                }
                
                // Place the new task at the beginning of the list
                goal.tasks.unshift({
                    'id': null,
                    'user_id': null,
                    'goal_id': null,
                    'category': category,
                    'task': '',
                    'is_completed': false,
                    'order': 0,
                    'vueUniqueItemId': Date.now()
                });
                
                // Mark parent goal as updated
                goal.newOrUpdated = true;
                
                // Show tasks container and focus on the newly created element after DOM is updated
                this.$nextTick(() => {
                    $(event.target).closest('.goal').find('.tasks__container').collapse('show');
                    $(event.target).closest('.goal').find('.task__text').first().focus();
                });
            },
            /*
            |--------------------------------------------------------------------------
            | addTask()
            |--------------------------------------------------------------------------
            |
            | Creates new task in local data and focuses on it after the DOM updates
            |
            */
            addTask: function(goal, event, taskIndex) {
                
                console.log('addTask method ran');
                
                // Adjust order up 1 for each item after the inserted item
                for(let i = taskIndex + 1; i < goal.tasks.length; i++) {
                    goal.tasks[i].order = i + 1;
                }
                
                // Mark parent goal as updated
                goal.newOrUpdated = true;
                
                // Splice the new item in forcing Vue to update
                goal.tasks.splice(taskIndex + 1, 0, {
                    'id': null,
                    'user_id': null,
                    'goal_id': null,
                    'category': goal.category,
                    'task': '',
                    'is_completed': false,
                    'order': taskIndex + 1,
                    'vueUniqueItemId': Date.now()
                });
                
                // Focus on the newly created element after DOM is updated
                this.$nextTick(() => {
                    $(event.target).closest('.task').next().find('.task__text').focus();
                });
            },
            
            
            
            
            
            
            
            
            /*
            |--------------------------------------------------------------------------
            | goalCompletionToggle()
            |--------------------------------------------------------------------------
            |
            | Toggle the completion of the goal
            |
            */
            goalCompletionToggle: function(goal) {
                console.log('goalCompletionToggle method ran');
                
                // If the goal is completed set to false, else set to true
                // --------------------------------------------------------------------
                goal.is_completed ? this.$set(goal, 'is_completed', false) : this.$set(goal, 'is_completed', true);
                
                // Mark the goal as updated
                // --------------------------------------------------------------------
                goal.newOrUpdated = true;
                
                // Debounce function that runs after no more input is being made
                // --------------------------------------------------------------------
                this.finishedInput();
            },
            /*
            |--------------------------------------------------------------------------
            | taskCompletionToggle()
            |--------------------------------------------------------------------------
            |
            | Toggle the completion of the task
            |
            */
            taskCompletionToggle: function(goal, task) {
                console.log('taskCompletionToggle method ran');
                
                // If the task is completed set to false, else set to true
                // --------------------------------------------------------------------
                task.is_completed ? this.$set(task, 'is_completed', false) : this.$set(task, 'is_completed', true);
                
                // Mark the goal as updated
                // --------------------------------------------------------------------
                goal.newOrUpdated = true;
                
                // Debounce function that runs after no more input is being made
                // --------------------------------------------------------------------
                this.finishedInput();
            },

            
            
            
            
            
            /*
            |--------------------------------------------------------------------------
            | goalInput()
            |--------------------------------------------------------------------------
            |
            | Handles when there is any input on a goal
            |
            */
            goalInput: function(goal, event) {
                console.log('goalInput method ran');
                
                // Update the local data with the new goal text
                // --------------------------------------------------------------------
                goal.goal = event.target.innerText;
                
                // Mark the goal as updated
                // --------------------------------------------------------------------
                goal.newOrUpdated = true;
                
                // After the DOM upates put the cursor at the end of the text
                // --------------------------------------------------------------------
                this.$nextTick(() => {                   
                    let range,selection;
                    if(document.createRange) { //Firefox, Chrome, Opera, Safari, IE 9+
                        range = document.createRange();
                        range.selectNodeContents(event.target);
                        range.collapse(false);
                        selection = window.getSelection();
                        selection.removeAllRanges();
                        selection.addRange(range);
                    }
                    else if(document.selection) { //IE 8 and lower
                        range = document.body.createTextRange();
                        range.moveToElementText(event.target);
                        range.collapse(false);
                        range.select();
                    }
                });
                
                // Debounce function that runs after no more input is being made
                // --------------------------------------------------------------------
                this.finishedInput();
            },
            /*
            |--------------------------------------------------------------------------
            | taskInput()
            |--------------------------------------------------------------------------
            |
            | Handles when there is any input on a task
            |
            */
            taskInput: function(goal, task, event) {
                console.log('updateTask method ran');
                
                // Update the local data with the new task text
                // --------------------------------------------------------------------
                task.task = event.target.innerText;
                
                // Mark the goal as updated
                // --------------------------------------------------------------------
                goal.newOrUpdated = true;
                
                // After the DOM upates put the cursor at the end of the text
                // --------------------------------------------------------------------
                this.$nextTick(() => {                   
                    let range,selection;
                    if(document.createRange) { //Firefox, Chrome, Opera, Safari, IE 9+
                        range = document.createRange();
                        range.selectNodeContents(event.target);
                        range.collapse(false);
                        selection = window.getSelection();
                        selection.removeAllRanges();
                        selection.addRange(range);
                    }
                    else if(document.selection) { //IE 8 and lower
                        range = document.body.createTextRange();
                        range.moveToElementText(event.target);
                        range.collapse(false);
                        range.select();
                    }
                });
                
                // Debounce function that runs after no more input is being made
                // --------------------------------------------------------------------
                this.finishedInput();
            },
            /*
            |--------------------------------------------------------------------------
            | dateInput()
            |--------------------------------------------------------------------------
            |
            | Handles when there is any input on the datepicker. V-model handles the
            | data binding.
            |
            */
            dateInput: function(goal) {
                console.log('dateInput method ran');
                
                // Mark the goal as updated
                // --------------------------------------------------------------------
                goal.newOrUpdated = true;
                
                // Debounce function that runs after no more input is being made
                // --------------------------------------------------------------------
                this.finishedInput();
            },
            /*
            |--------------------------------------------------------------------------
            | finishedInput()
            |--------------------------------------------------------------------------
            |
            | Handles when the user stops making any input
            |
            */
            finishedInput: finishedInputConst,
            /*
            |--------------------------------------------------------------------------
            | goalsSave()
            |--------------------------------------------------------------------------
            |
            | Handles saving goals to the database
            |
            */
            goalsSave: function() {
                console.log('goalsSave method ran from GoalsAll');
                
                // Cancel the finishedInput handler when 'save' button is clicked
                // --------------------------------------------------------------------
                finishedInputConst.cancel();
                
                // Let the root vue instance know about this
                // --------------------------------------------------------------------
                this.$emit('goals-saving');
                
                // Create an array of only updated goals
                // --------------------------------------------------------------------
                let newOrUpdatedGoals = [];
                $.each(this.goals, (categoryIndex, category) => {
                    $.each(category, (goalIndex, goal) => {
                        if(goal.newOrUpdated == true) newOrUpdatedGoals.push(goal);
                    })
                })
                
                // --------------------------------------------------------------------
                // Send the post request to the server
                axios.post('/api/goals', newOrUpdatedGoals).then((response) => {
                    console.log(response);
                    // If successfully saved goals
                    if(response.status == 200) {
                        this.$emit('goals-saved');
                        // Reset updated status of all goals
                        $.each(this.goals, (categoryIndex, category) => {
                            $.each(category, (goalIndex, goal) => {
                                goal.newOrUpdated = false;
                            })
                        })
                    }
                })
                .catch((error) => console.error(error));
            },
            
            
            
            
            
            
            
            
            
            
        
            /*
            |--------------------------------------------------------------------------
            | deleteGoal()
            |--------------------------------------------------------------------------
            |
            | Handles deleting goal from local data, remote database, and focusing on 
            | the previous item
            |
            */
            deleteGoal: function(goal, goalIndex, event, category) {
                console.log('deleteGoal method ran');
                
                if(event.target.innerText == 0) {
                    // Prevent deleting
                    event.preventDefault();

                    // Get previous element
                    let previousElement = $(event.target).closest('.goal').prev().find('.goal__text').get(0);

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

                    // Delete specific goal from DB if it's been saved to the DB
                    // and assigned an ID
                    if(goal.id !== null) {
                        console.log('Goal has an ID and will delete from DB!');
                        // Grab task IDs so we can delete them from the DB
                        let taskIds = [];
                        for(let i = 0; i < goal.tasks.length; i++) {
                            if(goal.tasks[i].id !== null) {
                                taskIds.push(goal.tasks[i].id);
                            }
                        }
                        // Send the delete request to the server
                        axios.delete('/api/goals', {
                            data: {
                                goalId: goal.id,
                                taskIds: taskIds
                            }
                         })
                        .then((response) =>{
                            console.log(response);
                        });
                    }
                    
                    // Adjust order down 1 for each item after the deleted item
                    for(let gi = goalIndex + 1; gi < this.goals[category].length; gi++) {
                        this.goals[category][gi].order = gi - 1;
                        this.goals[category][gi].newOrUpdated = true;
                    }

                    // Remove specific goal from local data (Also deletes tasks under it)
                    this.$delete(this.goals[category], goalIndex);
                }
            },
            /*
            |--------------------------------------------------------------------------
            | deleteTask()
            |--------------------------------------------------------------------------
            |
            | Handles deleting task from local data, remote database, and focusing on 
            | the previous item
            |
            */
            deleteTask: function(goal, task, taskIndex, event) {
                console.log('deleteTask method ran');
                
                if(event.target.innerText == 0) {
                    // Prevent deleting
                    event.preventDefault();

                    // Get previous element
                    let previousElement = $(event.target).closest('.task').prev().find('.task__text').get(0);
                    console.log(previousElement);

                    // Get next element
                    let nextElement = $(event.target).closest('.task').next().find('.task__text').get(0);

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
                    // If there's no previous element and no next element
                    else if(nextElement == undefined) {
                        $(event.target).closest('.goal').find('.tasks__container').collapse('hide');
                    }
                    // If there's no previous element and a next element
                    else {
                        nextElement.focus();
                        
                        let range,selection;
                        //Firefox, Chrome, Opera, Safari, IE 9+
                        if(document.createRange) {
                            range = document.createRange();
                            range.selectNodeContents(nextElement);
                            range.collapse(false);
                            selection = window.getSelection();
                            selection.removeAllRanges();
                            selection.addRange(range);
                        }
                        //IE 8 and lower
                        else if(document.selection) {
                            range = document.body.createTextRange();
                            range.moveToElementText(nextElement);
                            range.collapse(false);
                            range.select();
                        }
                    }

                    // Delete specific task from DB if it's been saved to the DB
                    // and assigned an ID
                    if(task.id !== null) {
                        console.log('Task has an ID and will delete from DB!');
                        // Send the delete request to the server
                        axios.delete('/api/task', {
                            data: {
                                taskId: task.id
                            }
                         })
                        .then((response) => {
                            console.log(response);
                        });
                    }
                    
                    // Adjust order down 1 for each item after the deleted item
                    for(let ti = taskIndex + 1; ti < goal.tasks.length; ti++) {
                        goal.tasks[ti].order = ti - 1;
                    }

                    // Mark parent goal as updated
                    goal.newOrUpdated = true;
                    
                    // Remove specific task from local data
                    this.$delete(goal.tasks, taskIndex);
                }
            },
        },
        directives: {
            /*
            |--------------------------------------------------------------------------
            | mediumjsGoal
            |--------------------------------------------------------------------------
            |
            | Create a new Medium instance on each goal
            |
            */
            mediumjsGoal: {
                bind: (el) => {
                    new Medium({
                        element: el,
                        mode: Medium.inlineMode,
                        maxLength: 255
                    });
                }
            },
            /*
            |--------------------------------------------------------------------------
            | mediumjsTask
            |--------------------------------------------------------------------------
            |
            | Create a new Medium instance on each task
            |
            */
            mediumjsTask: {
                bind: (el) => {
                    new Medium({
                        element: el,
                        mode: Medium.inlineMode,
                        maxLength: 255
                    });
                }
            }
        }
    }
</script>