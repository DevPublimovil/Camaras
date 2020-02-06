<template>
  <div class="p-0">
    <svg-icon  :width="500" :source="require('../svg/centroamerica-map.svg')" v-on:changeCountryData="changeCountry"
    class="fill-current black-dark-color"></svg-icon>
    <div class="row">
      <div class="d-flex col-12 align-items-center">
        <img class="img-fluid" :src="countries[this.selected_country].flag" alt="flag sv"><h3>{{countries[this.selected_country].name}}</h3>
      </div>
    </div>
    <div class="row">
      <div class="text-sm col-12">
        <p class="p-0">{{countries[this.selected_country].address}}</p>
        <a href="tel:+5032560-1100" class="nav-link p-0">{{countries[this.selected_country].phone}}</a>
        <a href="tel:+50325601129" v-if="this.selected_country == 0"  class="nav-link p-0">{{countries[this.selected_country].fax}}</a>
        <a :href="'mailto:'+countries[this.selected_country].email" class="nav-link p-0">Email: {{countries[this.selected_country].email}}</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      countries:[
        {
          name:"El Salvador",
          address:"Carretera a Comalapa Km 9 1/2, Centro Comercial Santorini, Local No. 6, San Marcos, San Salvador",
          phone:"Tel:  (503) 2560-1100",
          fax:"Fax: (503) 2560-1129",
          email:"info@grupopublimovil.com",
          flag:"../images/sv.png"
        },
        {
          name:"Guatemala",
          address:"Carretera a Comalapa Km 9 1/2, Centro Comercial Santorini, Local No. 6, San Marcos, San Salvador",
          phone:"Tel:  (502) 2319-6500",
          fax:"Fax: (503) 2560-1129",
          email:"info@grupopublimovil.com",
          flag:"../images/gt.png"
        },
        {
          name:"Costa Rica",
          address:"Carretera a Comalapa Km 9 1/2, Centro Comercial Santorini, Local No. 6, San Marcos, San Salvador",
          phone:"Tel:  (503) 2560-1100",
          fax:"Fax: (506) 4001-6297",
          email:"info@grupopublimovil.com",
          flag:"../images/cr.png"
        },
        {
          name:"Nicaragua",
          address:"Carretera a Comalapa Km 9 1/2, Centro Comercial Santorini, Local No. 6, San Marcos, San Salvador",
          phone:"Tel:  (505) 2252-5792",
          fax:"Fax: (503) 2560-1129",
          email:"info@grupopublimovil.com",
          flag:"../images/nc.png"
        },
        {
          name:"Honduras",
          address:"Carretera a Comalapa Km 9 1/2, Centro Comercial Santorini, Local No. 6, San Marcos, San Salvador",
          phone:"Tegucigalpa:  (504) 2239-8900 / San Pedro Sula:  (504) 2257-2534",
          fax:"Fax: (503) 2560-1129",
          email:"info@grupopublimovil.com",
          flag:"../images/hn.png"
        },
        {
          name:"Panama",
          address:"Carretera a Comalapa Km 9 1/2, Centro Comercial Santorini, Local No. 6, San Marcos, San Salvador",
          phone:"Tel:  (507) 397-8481",
          fax:"Fax: (503) 2560-1129",
          email:"info@grupopublimovil.com",
          flag:"../images/pn.png"
        },
      ],
      selected_country:0
    }
  },
  methods:{
    changeCountry(code){
      this.selected_country = code;
    }
  }
}
</script>
