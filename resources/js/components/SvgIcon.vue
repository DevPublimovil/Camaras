<template>
<svg  xmlns="http://www.w3.org/2000/svg"
    :width="svgWidth"
    :height="svgHeight"
    :viewBox="viewbox"
    role="presentation"
    v-html="content"
    @mouseover="handleStateHover"
></svg>
</template>

<script>
    export default{
        props: {
            src: {
            type: String,
            required: false
            },
            width: {
            type: [Number, String],
            default: 0
            },
            height: {
            type: [Number, String],
            default: 0
            },
            source: {
            type: String,
            default: ''
            },
        },
        data(){
            return{
                aisActive: 'fill-active',
            }
        },
        computed: {
            svg() {
            var div = document.createElement('div');
            div.innerHTML = this.src ? this.src : this.source;
            return div.firstChild;
            },
            content() {
            return this.svg.innerHTML;
            },
            svgWidth() {
            return this.width ? this.width : this.svg.getAttribute('width');
            },
            svgHeight() {
            return this.height ? this.height : this.svg.getAttribute('height');
            },
            viewbox() {
            return this.svg.getAttribute('viewbox') ||
                this.svg.getAttribute('viewBox');
            }
        },
         methods:{
            handleStateHover (e) {
                var code;
                if (e.target.tagName === 'path') {
                    if(e.target.id == 'c-6'){
                    code = 1;//gt
                    }else if(e.target.id == 'c-2'){
                    code = 0;//sv
                    }else if(e.target.id == 'c-3'){
                    code = 2;//cr
                    }else if(e.target.id=='c-4'){
                    code = 3;//nc
                    }else if(e.target.id=='c-5'){
                    code = 4;//hn
                    }else if(e.target.id=='c-1'){
                    code = 5;//pn
                    }
                    this.$emit('changeCountryData',code);
                }
            }
        },
    }
</script>
