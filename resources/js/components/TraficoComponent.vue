<template>
    <div class="clients-screens ">
        <div class="row justify-content-center">
            <div class="d-flex col-lg-6 col-md-6 col-xs-12 col-12 text-center justify-content-center align-items-center" id="circuito" >
                <h3 class="text-uppercase">Circuito {{user.country.name}}</h3>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12 col-12 text-center justify-content-center align-items-center" >
                <img :src="'../'+user.country.image"  class="img-fluid rounded-circle cameras" :alt="user.country.name"><span style="font-size:25px">{{user.country.pantallas}} Pantallas</span>
            </div>
        </div>
        <sv-component :user="user" :screns="pantallas"></sv-component>
    </div>
</template>

<script>
export default {
    props:['pantallas','user'],
    data(){
        return{

        }
    }
}
</script>