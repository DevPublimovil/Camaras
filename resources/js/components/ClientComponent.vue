<template>
    <div class="clients-screens ">
    <div class="row justify-content-center" v-if="pantallas.length > 0">
        <div class="d-flex col-lg-4 col-md-4 col-xs-12 col-12 text-center justify-content-center align-items-center" id="circuito" >
            <h3 class="text-uppercase">Circuito {{selectCountry}}</h3>
        </div>
        <div class="col-lg-8 col-md-8 col-xs-12 col-12 text-center justify-content-center align-items-center" >
            <ul class="nav justify-content-center">    
                <li class="nav-item" v-for="pais in paises " :key="pais.id" style="width:15%">
                    <a class="nav-link active" href="#" @click="changecountry(pais.id)"> <img :src="'../'+pais.image" class="img-fluid rounded-circle cameras" :alt="pais.name"></a>
                </li>
            </ul>
        </div>
    </div>
    <sv-component :screns="screens" :user="user" ></sv-component>
    </div>
</template>

<script>
    export default{
        props:['user','paises','pantallas'],
        data(){
            return{
                selectcountryId:'',
                selectPantalla:'',
                selectCountry:'',
                screens: []
            }
        },

        computed:{
            countryselect(){
                return this.screens;
            }
        },

        methods:{
            changecountry(country){
                axios.post('/mediacam/pantalla',{
                    pais:country
                }).then(({data})=>{
                    this.screens = data.pantallas;
                    this.selectcountryId = data.pais.id;
                    this.selectPantalla = data.pais.pantallas;
                    this.selectCountry = data.pais.name;
                });
            },
        },

        created(){
            this.screens = this.pantallas;
            this.selectcountryId = this.user.country.id;
            this.selectPantalla = this.user.country.pantallas;
            this.selectCountry = this.user.country.name;
        }
    }
</script>