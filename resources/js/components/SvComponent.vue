<template>
<div class="cameras mt-4">
    <div class="row justify-content-center" v-if="screns.length > 0">
        <div class="col-6">
            <div class="d-flex bd-highlight">
                <div class=" flex-grow-1 bd-highlight"><input class="form-control" type="search" v-model="name" placeholder="Buscar Pantallas" aria-label="Search"></div>
                <div class=" bd-highlight">
                    <button class="btn btn-search" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4" v-if="screns.length > 0">
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" v-for="pantalla in searchPantalla" :key="pantalla.id" data-aos="zoom-in" data-aos-delay="200">
            <div class="card shadow">
                <img :src="`../storage/${pantalla.image}`" class="card-img-top img-cameras" v-on:click="show(pantalla.id,pantalla.link,pantalla.name)" alt="pantalla.name">
                <div class="card-body">
                    <div class="row" style="border-left:2px solid #FF3C00">
                        <div class="col-10">
                        <p class="card-text">{{pantalla.name}}</p>
                        </div>
                        <div class="col-2"><i class="verpantalla fa fa-video-camera fa-2x" v-on:click="show(pantalla.id,pantalla.link,pantalla.name)" aria-hidden="true" title="Ver en vivo"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="col-12 text-center">
        <p>No se encontraron pantallas para mostrar</p>
    </div>
</div>
</template>

<script>
    import EventBus from '../eventbus.js';
    export default{
        props:['screns','user'],
        data(){
            return{
                name:'',
            }
        },

        computed:{
            searchPantalla(){
               return this.screns.filter((pantalla) => pantalla.name.toLowerCase().includes(this.name));
            }
        },

        methods:{
            show(pantalla,enlace,name){
                let vm = this
                axios.post('/mediacam/vistas/store/',{
                    user: this.user.id,
                    mipantalla:pantalla
                }).then(({data})=>{
                    
                });
                this.$modal.show('modal-camara',{iframe:enlace,id:pantalla,name:name});
            },
        },
    }
</script>
<style>
.card-img-top {
    width: 100%;
    height: 20vw;
    object-fit: cover;
}
.btn-search{
    background-color:#FF5733
}
</style>