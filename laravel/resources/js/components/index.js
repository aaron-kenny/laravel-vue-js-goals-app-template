import Vue from 'vue';

// Import components
import GoalCategory from './goal-category.vue';
import Goal from './goal.vue';
import Task from './task.vue';
import GoalPlaceholder from './goal-placeholder.vue';
import FlatPickr from 'vue-flatpickr-component';
import Draggable from 'vuedraggable';

// Import FontAwesome
import { library } from '@fortawesome/fontawesome-svg-core';
import { faSquare, faCheckSquare, faCalendar } from '@fortawesome/free-regular-svg-icons';
import { faGripLines, faUser, faEllipsisH, faList, faTimes, faFilter, faCreditCard, faTh } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faSquare, faCheckSquare, faGripLines, faUser, faEllipsisH, faList, faCalendar, faTimes, faFilter, faCreditCard, faTh);

// Register components
Vue.component('goal-category', GoalCategory);
Vue.component('goal', Goal);
Vue.component('task', Task);
Vue.component('goal-placeholder', GoalPlaceholder);
Vue.component('flat-pickr', FlatPickr);
Vue.component('draggable', Draggable);
Vue.component('font-awesome-icon', FontAwesomeIcon);