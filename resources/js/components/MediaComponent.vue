<template>
<div>
    <div id="content" :style="expanded ? 'display:block' : 'display:none'">
        <div class="breadcrumb-container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb filemanager">
                    <li class="breadcrumb-item media_breadcrumb" v-on:click="setCurrentPath(-1)">
                        <span class="arrow"></span>
                        <a href="#">Inicio</a>
                    </li>
                    <li class="breadcrumb-item" v-for="(folder, i) in getCurrentPath()" v-on:click="setCurrentPath(i)">
                        <span class="arrow"></span>
                        {{ folder }}
                    </li>
                </ol>
            </nav>
        </div>
        <div class="files">
            <div class="row">
                <div class="col-4" v-for="(file) in files" v-on:click="selectFile(file, $event)" v-on:dblclick="openFile(file)" v-if="filter(file)">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                            <img src="" class="card-img" alt="">
                            </div>
                            <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Image Modal -->
    <div class="modal fade" :id="'imagemodal_'+this._uid" v-if="selected_file && fileIs(selected_file, 'image')">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <img :src="selected_file.path" class="img img-responsive" style="margin: 0 auto;">
                </div>

                <div class="modal-footer text-left">
                    <small class="image-title">@{{ selected_file.name }}</small>
                </div>

            </div>
        </div>
    </div>
    <!-- End Image Modal -->
</div>
</template>

<script>
    export default{
        props: {
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
        data: function() {
            return {
                current_folder: '/Capturas',
		  		selected_files: [],
                files: [],
		  		is_loading: true,
                hidden_element: null,
                expanded: true,
                modals: {
                    new_folder: {
                        name: ''
                    },
                    move_files: {
                        destination: ''
                    }
                }
            };
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
            addFileToInput: function(file) {
                if (file.type != 'folder') {
                    if (!this.allowMultiSelect) {
                        this.hidden_element.value = file.relative_path;
                    } else {
                        var content = JSON.parse(this.hidden_element.value);
                        if (content.indexOf(file.relative_path) !== -1) {
                            return;
                        }
                        if (content.length >= this.maxSelectedFiles && this.maxSelectedFiles > 0) {
                            var msg_sing = "{{ trans_choice('voyager::media.max_files_select', 1) }}";
                            var msg_plur = "{{ trans_choice('voyager::media.max_files_select', 2) }}";
                            if (this.maxSelectedFiles == 1) {
                                toastr.error(msg_sing);
                            } else {
                                toastr.error(msg_plur.replace('2', this.maxSelectedFiles));
                            }
                        } else {
                            content.push(file.relative_path);
                            this.hidden_element.value = JSON.stringify(content);
                            this.$forceUpdate();
                        }
                    }
                }
            },
            removeFileFromInput: function(path) {
                if (this.allowMultiSelect) {
                    var content = JSON.parse(this.hidden_element.value);
                    if (content.indexOf(path) !== -1) {
                        content.splice(content.indexOf(path), 1);
                        this.hidden_element.value = JSON.stringify(content);
                        this.$forceUpdate();
                    }
                } else {
                    this.hidden_element.value = '';
                }
            },
            getSelectedFiles: function() {
                if (!this.allowMultiSelect) {
                    var content = [];
                    if (this.hidden_element.value != '') {
                        content.push(this.hidden_element.value);
                    }

                    return content;
                } else {
                    return JSON.parse(this.hidden_element.value);
                }
            },
            renameFile: function(object) {
                var vm = this;
                if (!this.allowRename || vm.selected_file.name == object.target.value) {
                    return;
                }
                axios.post('/mediacam/media/rename_file',{
                    folder_location: vm.current_folder,
                    filename: vm.selected_file.name,
                    new_filename: object.target.value,
                }).then(({data})=>{
                    if (data.success == true) {
						//toastr.success('{{ __('voyager::media.success_renamed') }}', "{{ __('voyager::generic.sweet_success') }}");
						vm.getFiles();
					} else {
						//toastr.error(data.error, "{{ __('voyager::generic.whoopsie') }}");
					}
                })
            },
            bytesToSize: function(bytes) {
				var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
				if (bytes == 0) return '0 Bytes';
				var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
				return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
			},
            getFileName: function(name) {
                var name = name.split('/');
                console.log(name)
                return name[name.length -1];
                
            },
            imgIcon: function(path) {
                path = path.replace(/\\/g,"/");
				return 'background-size: cover; background-image: url("' + path + '"); background-repeat:no-repeat; background-position:center center;display:inline-block; width:100%; height:100%;';
			},
            dateFilter: function(date) {
                if (!date) {
                    return null;
                }
                var date = new Date(date * 1000);

                var month = "0" + (date.getMonth() + 1);
                var minutes = "0" + date.getMinutes();
                var seconds = "0" + date.getSeconds();

                var dateFormated = date.getFullYear() + '-' + month.substr(-2) + '-' + date.getDate() + ' ' + date.getHours() + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);

                return dateFormated;
            },
            endsWithAny: function(suffixes, string) {
                return suffixes.some(function (suffix) {
                    return string.endsWith(suffix);
                });
            }
        },
        mounted: function() {
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

            //Key events
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
.dd-placeholder {
    flex: 1;
    width: 100%;
    min-width: 200px;
    max-width: 250px;
}
.file_link .link_icon {
    margin-left: 5px;
    margin-right: 0;
}
</style>
