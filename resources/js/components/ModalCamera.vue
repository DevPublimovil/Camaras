<template>
    <div class="modal-camera d-flex" >
        <modal id="modal-link" name="modal-camara" :draggable="true" :resizable="true" :adaptive="true" width="80%" height="80%" @before-open="beforeOpen">
            <iframe :src="enlace" frameborder="0" allowfullscreen width="100%" height="100%"></iframe>
        </modal>
    </div>
</template>

<script>
    export default{
		data(){
			return {
                enlace:''
			}
		},

        methods:{
            beforeOpen(event){
                this.enlace = event.params.iframe;
            }
        }
    }
</script>