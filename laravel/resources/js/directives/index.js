import Vue from 'vue';
import Medium from 'medium.js';

// Register directives
Vue.directive('tooltip', function(el, binding){
    $(el).tooltip({
        delay: {show: 500, hide: 0},
        title: binding.value,
        placement: binding.arg,
        trigger: 'hover'             
    })
});

Vue.directive('mediumJsGoal', {
    bind: (el) => {
        new Medium({
            element: el,
            mode: Medium.inlineMode,
            maxLength: 15
        });
    }
});

Vue.directive('mediumJsTask', {
    bind: (el) => {
        new Medium({
            element: el,
            mode: Medium.inlineMode,
            maxLength: 15
        });
    }
});
