import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        goalCategories: [],
        goals: [],
        tasks: []
    },
    getters: {
        // goalsWithoutCategories: state => {
        //     return state.goals.filter(goal => goal.goal_category_id == null).sort((a, b) => a.order - b.order).map(goal => {
        //         let tasks = this.$store.state.tasks.filter(task => task.goal_id == goal.id);
        //         goal.tasks = tasks;
        //         return goal;
        //     });
        // }
        goalsWithoutCategories: function(state) {
            return state.goals.filter(function(goal) {
                goal.goal_category_id == null;
            }).sort(function(a, b) {
                a.order - b.order;
            }).map(function(goal) {
                let tasks = this.$store.state.tasks.filter(function(task) {
                    task.goal_id == goal.id;
                });
                goal.tasks = tasks;
                return goal;
            });
        }
    },
    mutations: {
        setGoals(state, payload) {
            // state.goals = payload.goals;
            // state.goalCategories = payload.goalCategories;
            state.goalCategories = payload.goalCategories;
            state.goals = payload.goals;
            state.tasks = payload.tasks;
        },
        addTask(state, payload) {
            let newTask = {
                name: '',
                goal_id: payload.goal_uid,
                is_completed: false,
                uid: _.uniqueId()
            }
            let newTaskIndex = payload.task_index + 1;
            let existingTasks = state.tasks.filter(task => task.goal_id == payload.goal_uid).sort((a, b) => a.order - b.order);
            existingTasks.splice(newTaskIndex, 0, newTask);
            existingTasks = existingTasks.map((task, index) => {
                task.order = index;
                return task;
            });
            console.log(existingTasks);
        },
        updateGoalName(state, payload) {
            state.goals.find(goal => goal.uid == payload.goal_uid).name = payload.goal_name;
        },
        updateTaskName(state, payload) {
            state.tasks.find(task => task.uid == payload.task_uid).name = payload.task_name;
        },
        updateGoalOrder(state, goals) {
            state.goals = goals;
        },
        updateTaskOrder(state, payload) {
            payload.tasks = payload.tasks.map((task, taskIndex) => {
                task.order = taskIndex;
                task.goal_id = payload.goal_id;
                return task;
            });
            payload.tasks.forEach(item => {
                let taskIndex = state.tasks.findIndex(task => task.uid == item.uid);
                state.tasks[taskIndex] = item;
            });
        },
        updateGoalCategoryId(state, payload) {
            if(payload.goalCategoryId == null) {
                state.goals[payload.goalIndex].goal_category_id = null;
            } else {
                // state.goalCategories;
            }
        },
        updateGoalCompletion(state, payload) {
            state.goals.find(goal => goal.uid == payload.uid).is_completed = payload.is_completed;
        },
        updateTaskCompletion(state, payload) {
            state.tasks.find(task => task.uid == payload.uid).is_completed = payload.is_completed;
        }
    },
    actions: {
        // getAllGoals({commit}) {
        //     axios
        //     .get('/api/goals')
        //     .then(response => {
        //         this.loading = false;
        //         let goalsWithoutCategories = response.data.goals.map(goal => {
        //             goal.uniqueId = _.uniqueId();
        //             goal.tasks = goal.tasks.map(task => {
        //                 task.uniqueId = _.uniqueId();
        //                 return task;
        //             });
        //             return goal;
        //         });
        //         let goalsWithCategories = response.data.goal_categories.map(goalCategory => {
        //             goalCategory.uniqueId = _.uniqueId();
        //             goalCategory.goals = goalCategory.goals.map(goal => {
        //                 goal.uniqueId = _.uniqueId();
        //                 goal.tasks = goal.tasks.map(task => {
        //                     task.uniqueId = _.uniqueId();
        //                     return task;
        //                 });
        //                 return goal;
        //             });
        //             return goalCategory;
        //         });
        //         commit('setGoals', {
        //             goals: goalsWithoutCategories,
        //             goalCategories: goalsWithCategories,
        //         });
        //     })
        //     .catch(error => {
        //         this.loading = false;
        //         console.error(error);
        //         this.error = error.response.data.message || error.message;
        //     });
        // },
        getAllGoals({commit}) {
            axios
            .get('/api/goals')
            .then(response => {
                this.loading = false;
                let goalCategories = response.data.goal_categories.map(goalCategory => {
                    goalCategory.uid = _.uniqueId();
                    return goalCategory;
                });
                let goals = response.data.goals.map(goal => {
                    goal.uid = _.uniqueId();
                    return goal;
                });
                let tasks = response.data.tasks.map(task => {
                    task.uid = _.uniqueId();
                    return task;
                });
                commit('setGoals', {
                    goalCategories: goalCategories,
                    goals: goals,
                    tasks: tasks
                });
            })
            .catch(error => {
                this.loading = false;
                console.error(error);
                this.error = error.response.data.message || error.message;
            });
        }
    }
});
