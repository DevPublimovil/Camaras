<template>
    <div class="clients-screens ">
    <div class="row justify-content-center">
        <div class="d-flex col-lg-4 col-md-4 col-xs-12 col-12 text-center justify-content-center align-items-center" id="circuito" >
            <h3 class="text-uppercase">Circuito {{selectCountry}}</h3>
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
    <sv-component :screns="screens" :user="user" ></sv-component>
    </div>
</template>

<script>
    export default{
        props:['user','paises'],
        data(){
            return{
                selectcountryId:'',
                selectPantalla:'',
                selectCountry:'',
                screens: []
            }
        },

        methods:{
            getPantallas(id_country)
            {
                let vm = this
                axios.get('/mediacam/clients/' + id_country).then(({data})=>{
                    vm.screens = data
                })
            }
        },

        created(){
            this.getPantallas(this.user.country.id);
            this.selectcountryId = this.user.country.id;
            this.selectPantalla = this.user.country.pantallas;
            this.selectCountry = this.user.country.name;
        }
    }
</script>