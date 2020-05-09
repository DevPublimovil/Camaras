<template>
    <div class="clients-screens ">
    <div class="row justify-content-center">
        <div class="d-flex col-lg-4 col-md-4 col-xs-12 col-12 text-center justify-content-center align-items-center" id="circuito" >
            <h3 class="text-uppercase">Circuito {{countrySelect}}</h3>
        </div>
        <div class="col-lg-8 col-md-8 col-xs-12 col-12 text-center justify-content-center align-items-center" >
            <div v-if="user.role_id == 4">
                <img :src="'../'+user.country.image"  class="img-fluid rounded-circle cameras" :alt="user.country.name"><span style="font-size:25px">{{user.country.pantallas}} Pantallas</span>
            </div>
            <ul class="nav justify-content-center" v-else>    
                <li class="nav-item" v-for="pais in paises " :key="pais.id" style="width:15%">
                    <a class="nav-link active" href="#" @click="getPantallas(pais.id)"> <img :src="'../'+pais.image" class="img-fluid rounded-circle cameras" :alt="pais.name"></a> 
                </li>
            </ul>
        </div>
    </div>
    <div class="row justify-content-center mt-4" v-if="screens.length > 0">
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
    <div class="row mt-4" v-if="screens.length > 0">
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" v-for="(pantalla, index) in searchPantalla" :key="index" data-aos="zoom-in" data-aos-delay="200">
            <div class="card shadow">
                <img :data-src="`../storage/${pantalla.image}`" class="lazyload card-img-top img-cameras" v-on:click="show(pantalla.id,pantalla.link,pantalla.name)" alt="pantalla.name">
                <div class="card-body" style="height:110px">
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
import AOS from 'aos';
import 'lazysizes';
import EventBus from '../eventbus.js';
    export default{
        props:['user','paises'],
        data(){
            return{
                selectcountryId:'',
                selectPantalla:'',
                selectCountry:'',
                screens: [],
                name: ''
            }
        },

        computed:{
            searchPantalla(){
               return this.screens.filter((pantalla) => pantalla.name.toLowerCase().includes(this.name));
            },
            countrySelect(){
                if(this.selectcountryId == 1){
                    return "El salvador"
                }else if(this.selectcountryId == 2){
                    return "Guatemala"
                }
                else if(this.selectcountryId == 3){
                    return "Costa Rica"
                }
                else if(this.selectcountryId == 4){
                    return "Honduras"
                }
                else if(this.selectcountryId == 5){
                    return "Panama"
                }
                else if(this.selectcountryId == 6){
                    return "Nicaragua"
                }
            }
        },

        methods:{
            getPantallas(id_country)
            {
                let vm = this
                vm.screens = []
                vm.name = ''
                vm.selectcountryId = id_country
                axios.get('/mediacam/clients/' + id_country).then(({data})=>{
                    vm.screens = data
                })
            },
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

        created(){
            AOS.init();
            this.getPantallas(this.user.country.id);
            this.selectcountryId = this.user.country.id;
            this.selectPantalla = this.user.country.pantallas;
            this.selectCountry = this.user.country.name;
        }
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