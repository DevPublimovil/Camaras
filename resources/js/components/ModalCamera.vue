<template>
    <div  class="modal-camera">
        <modal class="overlay" id="modal-link" name="modal-camara" :draggable="true" :resizable="true" :adaptive="true" width="80%" height="70%"  @before-close="beforeClose" @before-open="beforeOpen">
            <span><i class="fa fa-camera capturas fa-2x" aria-hidden="true" @click="saveCapture()"></i></span>
            <img width="100%" height="100%" :src="enlace"  id="mimodal"  @load="onImgLoad">
            <div class="spinner-border text-warning isloading" role="status" v-if="!isLoaded">
                <span class="sr-only">Loading...</span>
            </div>
        </modal>
       
    </div>
</template>

<script>
    export default{
		data(){
			return {
                enlace:'',
                id:'',
                name:'',
                isLoaded: false,
			}
		},

        methods:{
            beforeOpen(event){
                this.enlace = '/mediacam/camara/'+event.params.iframe
                this.name = event.params.name
                this.id = event.params.id
            },
            beforeClose(){
                this.enlace = ''
                this.id = ''
                this.name=''
                //location.reload();
            },
            saveCapture(){
                var res = this.name.replace(/[^A-Z0-9]+/ig, "_")
                var fecha = moment().format('d_m_Y');
                var namepantalla = res+'_'+fecha+'.jpg'
                const canvas = document.getElementById('canvas');
                const ctx = canvas.getContext('2d');
                ctx.font = '16px sans-serif';
                ctx.textAlign = 'center';

                const img = new Image();
                img.src = this.enlace;
                const w = img.width,h = img.height;

                ctx.fillText('Source', w * .5, 20);
                ctx.drawImage(img, 0, 24, w, h);

                ctx.fillText('Smoothing = TRUE', w * 2.5, 20);
                ctx.imageSmoothingEnabled = true;
                ctx.drawImage(img, w, 24, w * 3, h * 3);

                ctx.fillText('Smoothing = FALSE', w * 5.5, 20);
                ctx.imageSmoothingEnabled = false;
                ctx.drawImage(img, w * 4, 24, w * 3, h * 3);
                var link = document.createElement('a');
                link.download = namepantalla;
                link.href = canvas.toDataURL()
                link.click();
            },
            onImgLoad(){
                this.isLoaded = true
            }
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
    .isloading{
        color: #FFFFFF;
        position: absolute;
        top: 50%;
        right:50%;
    }
</style>