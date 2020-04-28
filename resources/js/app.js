/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.jQuery = window.$ = $ = require('jquery');
window.Vue = require('vue');
window.moment = require('moment');

import VModal from 'vue-js-modal';

Vue.use(VModal);

import Multiselect from 'vue-multiselect';

Vue.component('multiselect', Multiselect);

window.toastr = require('toastr');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('modal-camera', require('./components/ModalCamera.vue').default);
Vue.component('select-pantalla', require('./components/SelectComponent.vue').default);
Vue.component('sv-component', require('./components/SvComponent.vue').default);
Vue.component('contact-map', require('./components/ContactMap.vue').default);
Vue.component('svg-icon', require('./components/SvgIcon.vue').default);
Vue.component('default-component', require('./components/DefaultComponent.vue').default);
Vue.component('client-component', require('./components/ClientComponent.vue').default);
Vue.component('media-component', require('./components/MediaComponent.vue').default);
Vue.component('agenda-component', require('./components/AgendaComponent.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data:{
        rango:1
    },
    methods:{
        ver(pantalla,enlace){
            this.$modal.show('modal-camara',{iframe:enlace,id:pantalla});
        },
        eliminarPantalla(pantalla)
        {
            axios.delete("/mediacam/trafico/" + pantalla).then(({data})=>{
                toastr.success('¡La pantalla ha sido eliminada de tu pauta!')
                window.location.reload();
            }).catch(({response})=>{
                toastr.error('¡Ocurrió un error, intentalo más tarde!')
            })
        }
    }
});
