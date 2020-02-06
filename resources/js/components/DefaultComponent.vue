<template>
        <div class="row cameras mt-4">
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" v-for="screen in screens" :key="screen.id">
            <div class="card" >
                <img :src="`../storage/${screen.image}`" class="card-img-top" alt="">
                    <div class="card-body">
                        <div class="row" style="border-left:2px solid #FF3C00">
                            <div class="col-10">
                            <p class="card-text">{{screen.name}}</p>
                            </div>
                            <div class="col-2"><i class="verpantalla fa fa-video-camera fa-2x" v-on:click="show(screen.link)" aria-hidden="true" ></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="screens.length == 0" class="col-12 text-center">
                <p>No se encontraron pantallas para mostrar</p>
            </div>
        </div>
    </div>
</template>

<script>

    import EventBus from '../eventbus.js';

    export default{
        props:['screens'],
        data(){
            return{

            }
        },

        methods:{
            show(enlace){
                this.$modal.show('modal-camara',{iframe:enlace});
            },
        },
    }
</script>