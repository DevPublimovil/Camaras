<template>
    <div  class="modal-camera">
        <modal class="overlay" id="modal-link" name="modal-camara" :draggable="true" :resizable="true" :adaptive="true" width="80%" height="100%" @before-open="beforeOpen">
            <span><i class="fa fa-camera capturas fa-2x" aria-hidden="true" @click="saveCapture()"></i></span>
            <img class="img-fluid" width="100%" height="100%" :src="enlace"  id="mimodal" >
        </modal>
    </div>
</template>

<script>
import html2canvas from 'html2canvas';
    export default{
		data(){
			return {
                enlace:'',
                id:'',
			}
		},

        methods:{
            beforeOpen(event){
                this.enlace = event.params.iframe;
                this.id = event.params.id;
            },
            saveCapture(){
                window.location="/mediacam/download/"+this.id
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