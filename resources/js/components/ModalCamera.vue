<template>
    <div  class="modal-camera">
        <modal class="overlay" id="modal-link" name="modal-camara" :draggable="true" :resizable="true" :adaptive="true" width="80%" height="70%" @before-close="beforeClose" @before-open="beforeOpen">
            <span><i class="fa fa-camera capturas fa-2x" aria-hidden="true" @click="saveCapture()"></i></span>
            <img width="100%" height="100%" :src="enlace"  id="mimodal" >
        </modal>
    </div>
</template>

<script>
    export default{
		data(){
			return {
                enlace:'',
                id:'',
			}
		},

        methods:{
            beforeOpen(event){
                let ip = '/mediacam/camara/'+event.params.iframe
                this.enlace = ip
                //this.enlace = event.params.iframe;
                this.id = event.params.id;
            },
            beforeClose(){
                this.enlace = ''
                this.id = ''
                location.reload();
            },
            saveCapture(){
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                toastr.info("¡Por favor espere mientras se descarga su imagen!")
                let theDate = new Date();
                window.location.href = "/mediacam/download/"+this.id+"/"+theDate.getTime().toString(10)
            },
        },
        
    }
</script>


<style>
    .capturas{
        color: #FFFFFF;
        position: absolute;
        top: 5px;
        right:25px;
        cursor:pointer;
    }
</style>