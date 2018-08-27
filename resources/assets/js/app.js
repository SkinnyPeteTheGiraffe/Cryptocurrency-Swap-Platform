
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./core/jquery.min.js');
require('./core/popper.min.js');
require('./core/bootstrap-material-design.min.js');

require('./plugins/moment.min.js');
require('./plugins/bootstrap-datetimepicker.js');
require('./plugins/nouislider.min.js');
require('./plugins/bootstrap-tagsinput.js');
require('./plugins/bootstrap-selectpicker.js');
require('./plugins/jasny-bootstrap.min.js');
//require('../demo/modernizr.js');
require('../demo/vertical-nav.js');
require('./material-kit.js');

require('datatables');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});
