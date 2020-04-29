<template>
    <div>
        <div class="row justify-content-center">
            <div class="d-flex col-lg-4 col-md-4 col-xs-12 col-12 text-center justify-content-center align-items-center" id="circuito" >
                <h3 class="text-uppercase">Circuito {{selectCountry}}</h3>
            </div>
            <div class="col-lg-8 col-md-8 col-xs-12 col-12 text-center justify-content-center align-items-center mb-4" >
                <ul class="nav justify-content-center">    
                    <li class="nav-item" v-for="(pais, index) in paises " :key="index" style="width:15%">
                        <a class="nav-link active" href="#" @click="changecountry(pais.id)"> <img :src="'../'+pais.image" class="img-fluid rounded-circle cameras" :alt="pais.name"></a>
                    </li>
                </ul>
            </div>
        </div>
        <nav aria-label="breadcrumb">
            
            <ol class="breadcrumb">
                <li>
                    <label for="capturas_upload" class="btn btn-primary btn-sm mr-4" style="cursor:pointer">Cargar capturas</label>
                    <input type="file" id="capturas_upload" style="display:none" @change="uploadImage()" accept="image/*" multiple>
                </li>
                <li class="breadcrumb-item" v-for="(folder, i) in getCurrentPath()" :key="i" v-on:click="setCurrentPath(i)">
                    {{ folder }}
                </li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12">
                <div class="d-flex bd-highlight">
                    <div class=" flex-grow-1 bd-highlight">
                        <input class="form-control" type="search" v-model="name" placeholder="Buscar Pantallas" aria-label="Search">
                    </div>
                    <div class=" bd-highlight">
                        <button class="btn btn-search" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="d-flex">
                    <ul id="files">
                        <li class="items_list" v-for="(file, index) in  searchPantalla" v-on:click="selectFile(file, $event)" :key="index" v-on:dblclick="openFile(file)" v-if="filter(file)" :id="index" draggable="true" v-on:dragstart="dragStart" data-aos="zoom-in" data-aos-delay="200">
                            <div :class="'file_link '+ (isFileSelected(file) ? 'selected' : '')" >
                                <div class="link_icon" >
                                    <template v-if="fileIs(file, 'image')">
                                        <img :data-src="file.path" class="lazyload" width="100%" height="auto" :id="index" draggable="true" v-on:dragstart="dragStart">
                                    </template>
                                    <template v-else-if="fileIs(file, 'folder')">
                                        <i class="icon fa fa-folder" aria-hidden="true"></i>
                                    </template>
                                </div>
                                <div class="details pl-1" v-if="!fileIs(file, 'image')">
                                    <div :class="file.type">
                                        <h4>{{ file.name }}</h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="fijo-top ">
                <div class="right_details">
                    <div v-if="selected_files.length == 1 " class="right_details">
                        <div class="detail_img">
                            <!--<div v-if="fileIs(selected_file, 'image')">
                                <img class="img-fluid img-thumbnail" id="preview" :src="selected_file.path" />
                            </div>-->
                            <div v-if="fileIs(selected_file, 'folder')" class="text-center">
                                <div class="d-flex justify-content-around">
                                    <i class="icon fa fa-folder fa-5x mt-4" aria-hidden="true"></i>
                                </div>
                                 <small>{{ selected_file.name }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="right_details" v-else-if="relative_path != ''">
                        <div class="detail_img">
                            <img class="img-fluid img-thumbnail" id="preview" :src="imageselect" />
                        </div>
                    </div>
                    <div class="row mt-2" v-if="selectFiles.length > 0">
                        <div class="col-12">
                            <button class="btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#insertDescription">Generara reporte</button>
                            <small class="text-info">Has agregado {{ selectFiles.length }} capturas</small>
                        </div>
                    </div>
                </div>

                <div class="midrop" :class="(selectFiles.length == 0) ? 'droptarget' : ''" v-on:drop="drop" v-on:dragover="allowDrop">
                    <p class="text-secondary font-weight-bold message_drag" v-if="selectFiles.length==0">Suelte sus capturas aquí</p>
                    <div class="row" >
                        <div class="col-md-12">
                            <ul class="list-group">
                                <li class="list-group-item captura_select p-1 m-1" v-for="(item, index) of selectFiles" :key="index">
                                    <div class="row">
                                        <div class="col-11 " v-on:click="selectImage(index)">
                                            {{'Captura '+parseInt(index+1)}} 
                                        </div>
                                        <div class="col-1">
                                            <span >
                                                <button class="btn btn-sm btn-danger pull-right" v-on:click="deleteStorage(index)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>

        <!-- Image Modal -->
        <div class="modal fade" :id="'imagemodal_'+this._uid" v-if="selected_file && fileIs(selected_file, 'image')">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <img :src="selected_file.path" class="img img-fluid" style="margin: 0 auto;">
                    </div>

                    <div class="modal-footer text-left">
                        <small class="image-title">{{ selected_file.name }}</small>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Image Modal -->
        <!-- Image Modal -->
        <div class="modal fade" id="insertDescription">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        Descripción
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <form action="/mediacam/reportes" method="POST" id="formDescription">
                        <div class="modal-body">
                        <input type="hidden" name="_token" :value="csrf">
                        <div class="form-group" v-for="(file, index) in selectFiles" v-bind:key="index">
                            <input type="hidden" name="imagenes[]" :value="file">
                        </div>
                        <div class="form-group">
                            <label for="marca">Marca:</label>
                            <input type="text" class="form-control" name="marca" id="marca" required placeholder="Marca">
                        </div>
                        <label for="description">Descripción:</label>
                        <textarea class="form-control" name="descripcion" id="description" cols="30" rows="10" v-model="description"></textarea>
                        </div>

                        <div class="modal-footer text-center">
                            <button type="button" class="btn btn-sm btn-primary" v-on:click="generarResporte()">Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Image Modal -->
    </div>
</template>

<script>
import AOS from 'aos';
import 'lazysizes';
export default {
    props: {
            paises:{
                type: Array,
                default: function() {
                    return [];
                }
            },
            countryselect:{
                type: Number,
            },
            basePath: {
                type: String,
                default: '/'
            },
            filename: {
                type: String,
                default: null
            },
            allowMultiSelect: {
                type: Boolean,
                default: true
            },
            maxSelectedFiles: {
                type: Number,
                default: 0
            },
            minSelectedFiles: {
                type: Number,
                default: 0
            },
            showFolders: {
                type: Boolean,
                default: true
            },
            showToolbar: {
                type: Boolean,
                default: true
            },
            allowUpload: {
                type: Boolean,
                default: true
            },
            allowMove: {
                type: Boolean,
                default: true
            },
            allowDelete: {
                type: Boolean,
                default: true
            },
            allowCreateFolder: {
                type: Boolean,
                default: true
            },
            allowRename: {
                type: Boolean,
                default: true
            },
            allowCrop: {
                type: Boolean,
                default: true
            },
            allowedTypes: {
                type: Array,
                default: function() {
                    return [];
                }
            },
            preSelect: {
                type: Boolean,
                default: true,
            },
            element: {
                type: String,
                default: ""
            },
            details: {
                type: Object,
                default: function() {
                    return {};
                }
            },
        },
    data(){
        return{
            current_folder: '/el_salvador/',
            selected_files: [],
            files: [],
            hidden_element: null,
            expanded: true,
            idcountry:1,
            selectCountry:'',
            selectFiles:[],
            description:'',
            csrf:'',
            relative_path:'',
            name:'',
        }
    },

    computed: {
            selected_file: function() {
                return this.selected_files[0];
            },
            imageselect: function(){
                return '/storage/'+this.relative_path;
            },
            searchPantalla(){
               return this.files.filter((pantalla) => pantalla.name.toLowerCase().includes(this.name));
            }
        },
    methods: {
        getFiles: function() {
            var vm = this;
            axios.post('/mediacam/medios/files',{
                folder: vm.current_folder,
                country:vm.idcountry
            }).then(({data})=>{
                vm.current_folder = data.current_folder
                this.selectCountry = data.country.name
                vm.files = [];
                for (var i = 0, file; file = data.files[i]; i++) {
                    if (vm.filter(file)) {
                        vm.files.push(file);
                    }
                }
                vm.selected_files = [];
                if (vm.preSelect && data.length > 0) {
                    vm.selected_files.push(data[0]);
                }
            })
        },
        changecountry(country){
            this.idcountry = country
            if(country == 1){
                this.current_folder = '/el_salvador/'
            }else if(country == 2){
                this.current_folder = '/guatemala/'
            }else if(country == 3){
                this.current_folder = '/costa_rica/'
            }else if(country == 4){
                this.current_folder = '/honduras/'
            }else if(country == 5){
                this.current_folder = '/panama/'
            }else if(country == 6){
                this.current_folder = '/nicaragua/'
            }
            this.getFiles();
        },
        dragStart(event) {
            event.dataTransfer.setData("Text", event.target.id);
        },
        /* dragging:function(event) {
            document.getElementById("demo").innerHTML =
              "The p element is being dragged";
        }, */
        allowDrop:function(event) {
            event.preventDefault();
        },
        drop:function(event) {
            event.preventDefault();
            var data = event.dataTransfer.getData("Text");
            this.selected_files.push(this.files[data]);
            if(this.files[data] != null){
                if(this.files[data].type != "folder"){
                    this.selectFiles.push(this.files[data].relative_path);
                    localStorage.setItem('capturas-vue', JSON.stringify(this.selectFiles));
                    toastr.success('¡La captura ha sido agragada!')
                }else{
                    toastr.error('Tienes que arrastrar una imagen');
                }
            }else{
                toastr.error('Tienes que arrastrar una imagen');
            }
        },
        isFileSelected: function(file) {
            return this.selected_files.includes(file)
        },
        selectImage(file){
            this.relative_path = this.selectFiles[file];
        },
        deleteStorage(item){
            this.selectFiles.splice(item,1)
            localStorage.setItem('capturas-vue', JSON.stringify(this.selectFiles));
            toastr.success('La captura ha sido removida')
            //document.getElementById('preview').src = ''
        },
        uploadImage(){
            var formData = new FormData();
            var imagefile = document.querySelector('#capturas_upload');
            for (let i = 0; i < imagefile.files.length; i++) {
                formData.append("image[]", imagefile.files[i]);
            }
            axios.post('/mediacam/medios', formData, {
                headers: {
                'Content-Type': 'multipart/form-data'
                }
            }).then(({data})=>{
                for (let j = 0; j < data.length; j++) {
                    const element = data[j];
                    this.selectFiles.push(element);
                    localStorage.setItem('capturas-vue', JSON.stringify(this.selectFiles));
                }
                toastr.success('¡Las capturas han sido agragadas!')
            })
        },
        fileIs: function(file, type) {
            if (typeof file === 'string') {
                if (type == 'image') {
                    return this.endsWithAny(['jpg', 'jpeg', 'png', 'bmp'], file);
                }
                //Todo: add other types
            } else {
                return file.type.includes(type);
            }

            return false;
        },
        imgIcon: function(path) {
            path = path.replace(/\\/g,"/");
            return 'background-size: cover; background-image: url("' + path + '"); background-repeat:no-repeat; background-position:center center;display:inline-block; width:80%; :80%;';
        },
        generarResporte(){
            if($("#marca").val() != ''){
                toastr.info('¡Espere un momento mientras se genera el reporte!')
                $("#formDescription").submit();
                document.getElementById('formDescription').reset();
                $("#insertDescription").modal('hide');
                localStorage.clear()
                this.selectFiles = []
            }else{
                $("#marca").css("border","1px solid red");
                $("#marca").focus();
                toastr.error('La marca es requerida');
            }
        },
        bytesToSize: function(bytes) {
            var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            if (bytes == 0) return '0 Bytes';
            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
            return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
        },
        filter: function(file) {
            if (this.allowedTypes.length > 0) {
                if (file.type != 'folder') {
                    for (var i = 0, type; type = this.allowedTypes[i]; i++) {
                        if (file.type.includes(type)) {
                            return true;
                        }
                    }
                }
            }

            if (file.type == 'folder' && this.showFolders) {
                return true;
            } else if (file.type == 'folder' && !this.showFolders) {
                return false;
            }
            if (this.allowedTypes.length == 0) {
                return true;
            }

            return false;
        },
        openFile: function(file) {
            if (file.type == 'folder') {
                this.current_folder += file.name+"/";
                this.getFiles();
                this.name = ''
            } else if (this.hidden_element) {
                this.addFileToInput(file);
            } else {
                if (this.fileIs(this.selected_file, 'image')) {
                    $('#imagemodal_' + this._uid).modal('show');
                } else {
                    // ...
                }
            }
            
        },
        selectFile: function(file, e) {
            if ((!e.ctrlKey && !e.metaKey && !e.shiftKey) || !this.allowMultiSelect) {
                this.selected_files = [];
            }


            if (e.shiftKey && this.allowMultiSelect && this.selected_files.length == 1) {
                var index = null;
                var start = 0;
                for (var i = 0, cfile; cfile = this.files[i]; i++) {
                    if (cfile === this.selected_file) {
                        start = i;
                        break;
                    }
                }

                var end = 0;
                for (var i = 0, cfile; cfile = this.files[i]; i++) {
                    if (cfile === file) {
                        end = i;
                        break;
                    }
                }

                for (var i = start; i < end; i++) {
                    index = this.selected_files.indexOf(this.files[i]);
                    if (index === -1) {
                        this.selected_files.push(this.files[i]);
                    }
                }
            }

            index = this.selected_files.indexOf(file);
            if (index === -1) {
                this.selected_files.push(file);
            }
        },
        getCurrentPath: function() {
            var path = this.current_folder.replace(this.basePath, '').split('/').filter(function (el) {
                return el != '';
            });

            return path;
        },
        setCurrentPath: function(i) {
            if (i == -1) {
                this.current_folder = this.basePath;
            } else {
                var path = this.getCurrentPath();
                path.length = i + 1;
                this.current_folder = this.basePath+path.join('/');
                this.current_folder = this.current_folder + '/'
            }

            this.getFiles();
        },
    },
    mounted() {
        this.csrf = document.querySelector('meta[name="csrf-token"]').content
        this.getFiles();
        var vm = this;

        /* window.addEventListener("keypress", e => {
            console.log(e.keyCode);
        }); */
        document.onkeydown = function(e) { 
            switch (e.keyCode) { 
                case 37:
                    let index = vm.files.indexOf(vm.selected_files[0])
                    let nuevoindex = parseInt(index-1)
                    if(nuevoindex >= 0){
                        vm.selected_files = []
                        vm.selected_files.push(vm.files[nuevoindex])
                         $('html, body').animate({scrollTop: '-=50px'}, 20);
                    }
                    break; 
                case 38: 
                    let index2 = vm.files.indexOf(vm.selected_files[0])
                    let nuevoindex2 = parseInt(index2-3)
                    if(nuevoindex2 >= 0 ){
                        vm.selected_files = []
                        vm.selected_files.push(vm.files[nuevoindex2])
                    }
                    break; 
                case 39: 
                    let index3 = vm.files.indexOf(vm.selected_files[0])
                    let nuevoindex3 = parseInt(index3+1)
                    if(nuevoindex3 < vm.files.length){
                        vm.selected_files = []
                        vm.selected_files.push(vm.files[nuevoindex3])
                        $('html, body').animate({scrollTop: '+=50px'}, 20);
                    }
                    break; 
                case 40: 
                    let index4 = vm.files.indexOf(vm.selected_files[0])
                    let nuevoindex4 = parseInt(index4+3)
                    if(nuevoindex4 < vm.files.length){
                        vm.selected_files = []
                        vm.selected_files.push(vm.files[nuevoindex4])
                    }
                    break; 
            } 
        }; 
    },
    created() {
        AOS.init();
        let datosDB = JSON.parse(localStorage.getItem('capturas-vue'));
        if(datosDB == null){
            this.selectFiles = [];
        }else{
            this.selectFiles = datosDB;  
        }

        if(this.countryselect == 1){
            this.current_folder = '/el_salvador/'
        }else if(this.countryselect == 2){
            this.current_folder = '/guatemala/'
        }else if(this.countryselect == 3){
            this.current_folder = '/costa_rica/'
        }else if(this.countryselect == 4){
            this.current_folder = '/honduras/'
        }else if(this.countryselect == 5){
            this.current_folder = '/panama/'
        }else{
            this.current_folder = '/nicaragua/'
        }
    },
}
</script>

<style>
#files {
    display: -webkit-box;
    display: flex;
    list-style: none;
    width: 100%;
    margin: 0;
    flex-wrap: wrap;
    padding: 10px;
    position: relative;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
#files li .file_link{
    background: #eee;
    padding: 10px;
    margin: 10px;
    cursor: pointer;
    border-radius: 3px;
    border: 1px solid #ecf0f1;
    overflow: hidden;
    background: #f6f8f9;
    display: -webkit-box;
    display: flex;
}
#files li .details .folder h4 {
    margin-top: 16px;
}
#files li .details h4 {
    margin-bottom: 2px;
    margin-top: 10px;
    max-height: 17px;
    height: 17px;
    overflow: hidden;
    font-size: 14px;
    text-overflow: ellipsis;
}
h4 {
    display: block;
    margin-block-start: 1.33em;
    margin-block-end: 1.33em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}
#files li .file_link .details {
    -webkit-box-flex: 2;
    flex: 2;
    overflow: hidden;
    width: 100%;
}
#files li .file_link.selected, #files li .file_link:hover {
    background: #FC876E!important;
    border-color: #FB3D14;
    color: #fff;
}
ul {
    display: block;
    list-style-type: disc;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}
div {
    display: block;
}
.file_link i.icon:before {
    font-size: 40px;
}
#files li .file_link .details small {
    font-size: 11px;
    position: relative;
    top: -3px;
}
.items_list{
    width: 33%;
}
.captura_select{
    cursor:pointer;
}

.captura_select:hover{
    background-color:#FC876E;
    color:#FFF
}
.breadcrumb-item:hover{
    color:#FB3D14
}
.droptarget{
    display: flex;
    align-items: center;
    justify-content: center;
}
.midrop{
    border-radius: 5px;
    border: 2px solid #ccc!important;
    min-height:200px;
}
.breadcrumb-item{
    cursor:pointer
}
.fijo-top{
    position:-webkit-sticky;
    position:sticky;
    top:100px;
    z-index:1020
}
</style>