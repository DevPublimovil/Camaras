<template>
<div class="cameras mt-4">
    <div class="row justify-content-center" v-if="screns.length > 0">
        <div class="col-6">
             <input class="form-control" type="search" v-model="name" placeholder="Buscar Pantallas" aria-label="Search">
        </div>
    </div>
    <div class="row mt-4" v-if="user.status == 'activo'">
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" v-for="pantalla in searchPantalla">
            <div class="card shadow">
                <img :src="`../storage/${pantalla.image}`" class="card-img-top img-cameras" v-on:click="show(pantalla.link,pantalla.country_id)" alt="pantalla.name">
                    <div class="card-body">
                        <div class="row" style="border-left:2px solid #FF3C00">
                            <div class="col-10">
                            <p class="card-text">{{pantalla.name}}</p>
                            </div>
                            <div class="col-2"><i class="verpantalla fa fa-video-camera fa-2x" v-on:click="show(pantalla.link,pantalla.country_id)" aria-hidden="true" title="Ver en vivo"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="screns.length == 0" class="col-12 text-center">
                <p>No se encontraron pantallas para mostrar</p>
            </div>
        </div>
    </div>
</div>
</template>

<script>

    import EventBus from '../eventbus.js';

    export default{
        props:['screns','user'],
        data(){
            return{
                name:''
            }
        },

        computed:{
            searchPantalla(){
               return this.screns.filter((pantalla) => pantalla.name.toLowerCase().includes(this.name));
            }
        },

        methods:{
            show(enlace,tipo){
                if(tipo == 1){
                    this.$modal.show('modal-camara',{iframe:enlace});
                }else{
                    window.open(enlace, '_blank');
                }
            },
        },
    }
</script>