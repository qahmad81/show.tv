/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vue2Editor from "vue2-editor";

Vue.use(Vue2Editor);

import Form from './Form';

window.Form = Form;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('test-component', require('./components/TestComponent.vue').default);

Vue.component('show-series-component', require('./components/ShowSeriesComponent.vue').default);

Vue.component('add-series-component', require('./components/AddSeriesComponent.vue').default);
Vue.component('edit-series-component', require('./components/EditSeriesComponent.vue').default);

Vue.component('vue-editor-episode', require('./components/vueEditorEpisode.vue').default);
Vue.component('vue-editor-series', require('./components/vueEditorSeries.vue').default);

Vue.component('add-episode-component', require('./components/AddEpisodeComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
