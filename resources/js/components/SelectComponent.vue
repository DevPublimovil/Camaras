<!-- Vue component -->
<template>
  <div class="row justify-content-center">
        <div class="col-lg-8 col-md-8 col-xs-12 col-12">
            <div class="card shadow shadow-lg">
                <div class="card-header">
                    Agregar artículos a {{cliente.name}}
                </div>
                <div class="card-body">
                    <label for="">Artículos:</label>
                        <multiselect v-model="value" :options="options" :multiple="true"></multiselect>
                        <div class="form-group mt-2  text-center">
                            <button type="button" class="btn btn-secondary" @click="cancelar()">Cancelar</button>
                            <button type="button" class="btn btn-primary" @click="enviardatos()">Guardar</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
 
  export default {
      props:['articulos','cliente','user'],
    data () {
      return {
        value: [],
        options: []
      }
    },

    methods: {
        enviardatos(){
            let vm = this
            axios.post('/mediacam/clients', {
                pantallas:this.value,
                cliente:this.cliente.id
            }).then(function(response){
                 toastr.success('Los articulos se agregaron correctamente!');
                 if(vm.user == 5 || vm.user == 6)
                 {
                     location.href='/mediacam/ventas';
                 }else{
                     location.href='/mediacam/trafico';
                 }
            });
        },
        cancelar(){
            let vm = this
            if(vm.user == 5 || vm.user == 6)
            {
                location.href='/mediacam/ventas';
            }else{
                location.href='/mediacam/trafico';
            }
        }
    },

    created() {
        for(var i = 0; i < this.articulos.length; i++){
            this.options.push(this.articulos[i].name)
        }
    },
  }
</script>

<!-- New step!
     Add Multiselect CSS. Can be added as a static asset or inside a component. -->
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
