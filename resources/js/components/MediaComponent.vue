<template>
    <div>
        <div class="row justify-content-center">
            <div class="d-flex col-lg-4 col-md-4 col-xs-12 col-12 text-center justify-content-center align-items-center" id="circuito" >
                <h3 class="text-uppercase">Circuito {{selectCountry}}</h3>
            </div>
            <div class="col-lg-8 col-md-8 col-xs-12 col-12 text-center justify-content-center align-items-center" >
                <ul class="nav justify-content-center">    
                    <li class="nav-item" v-for="(pais, index) in paises " :key="pais.id" style="width:15%">
                        <a class="nav-link active" href="#" @click="changecountry(pais.id)"> <img :src="'../'+pais.image" class="img-fluid rounded-circle cameras" :alt="pais.name"></a>
                    </li>
                </ul>
            </div>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" v-for="(folder, i) in getCurrentPath()" v-on:click="setCurrentPath(i)">
                    {{ folder }}
                </li>
            </ol>
        </nav>
        <div class="d-flex">
            <ul id="files">
                <li v-for="(file) in files" v-on:click="selectFile(file, $event)" v-on:dblclick="openFile(file)" v-if="filter(file)">
                    <div :class="'file_link ' + (isFileSelected(file) ? 'selected' : '')">
                        <div class="link_icon">
                            <template v-if="fileIs(file, 'image')">
                                <img :src="file.path" width="65px">
                            </template>
                            <template v-else="fileIs(file, 'folder')">
                                <i class="icon fa fa-folder" aria-hidden="true"></i>
                            </template>
                        </div>
                        <div class="details pl-1" >
                            <div :class="file.type">
                                <h4>{{ file.name }}</h4>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Image Modal -->
        <div class="modal fade" :id="'imagemodal_'+this._uid" v-if="selected_file && fileIs(selected_file, 'image')">
            <div class="modal-dialog">
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
    </div>
</template>

<script>
export default {
    props: {
            paises:{
                type: Array,
                default: function() {
                    return [];
                }
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
                selectCountry:'El Salvador',
                modals: {
                    new_folder: {
                        name: ''
                    },
                    move_files: {
                        destination: ''
                    }
                }
        }
    },

    computed: {
            selected_file: function() {
                return this.selected_files[0];
            }
        },
    methods: {
        getFiles: function() {
            var vm = this;
            axios.post('/mediacam/medios/files',{
                folder: vm.current_folder
            }).then(({data})=>{
                vm.files = [];
                for (var i = 0, file; file = data[i]; i++) {
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
            
        },
        isFileSelected: function(file) {
            return this.selected_files.includes(file);
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

            if (this.selected_files.length == 1) {
                var vm = this;
                Vue.nextTick(function () {
                    if (vm.fileIs(vm.selected_file, 'video')) {
                        vm.$refs.videoplayer.load();
                    } else if (vm.fileIs(vm.selected_file, 'audio')) {
                        vm.$refs.audioplayer.load();
                    }
                });
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
            }

            this.getFiles();
        },
    },
    mounted() {
        this.getFiles();
        var vm = this;

        if (this.element != '') {
            this.hidden_element = document.querySelector(this.element);
            if (!this.hidden_element) {
                console.error('Element "'+this.element+'" could not be found.');
            } else {
                if (this.maxSelectedFiles > 1 && this.hidden_element.value == '') {
                    this.hidden_element.value = '[]';
                }
            }
        }

        this.onkeydown = function(evt) {
            evt = evt || window.event;
            if (evt.keyCode == 39) {
                evt.preventDefault();
                for (var i = 0, file; file = vm.files[i]; i++) {
                    if (file === vm.selected_file) {
                        i = i + 1; // increase i by one
                        i = i % vm.files.length;
                        vm.selectFile(vm.files[i], evt);
                        break;
                    }
                }
            } else if (evt.keyCode == 37) {
                evt.preventDefault();
                for (var i = 0, file; file = vm.files[i]; i++) {
                    if (file === vm.selected_file) {
                        if (i === 0) {
                            i = vm.files.length;
                        }
                        i = i - 1;
                        vm.selectFile(vm.files[i], evt);
                        break;
                    }
                }
            } else if (evt.keyCode == 13) {
                evt.preventDefault();
                if (evt.target.tagName != 'INPUT') {
                    vm.openFile(vm.selected_file, null);
                }
            }
        };
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
    background: #4da7e8!important;
    border-color: #2581b8;
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
</style>