<template>
  <div>
    <!-- Main content -->
    <section class="content mt-2">
      <div class="container-fluid">
        <!-- <div class="row justify-content-center mb-2">
          <div class="col-11">
            <h1>Cliente:</h1>
            <input type="search" v-model="search" class="form-control">
            <button type="button" class="btn btn-sm btn-secondary" @click="buscarEvento(search)">Buscar</button>
          </div>
        </div> -->
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card card-primary" >
              <div class="card-body p-0">
                <!-- THE CALENDAR -->
                <FullCalendar
                class="demo-app-calendar"
                ref="fullCalendar"
                defaultView="dayGridMonth"
                :header="{
                     left:   'title',
                      center: '',
                      right:  'prev,next'
                    //right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                }"
                :plugins="calendarPlugins"
                :weekends="calendarWeekends"
                :editable="true"
                :height="650"
                :droppable="true"
                :events="updateAgenda"
                @dateClick="handleDateClick"
                @drop="dropEvent"
                @eventClick="viewEvent"
                @eventDrop="eventResize"
                @eventResize="eventResize"
                />
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-4">
            <div class="card shadow-sm">
              <div class="card-header">
                <h1 class="card-title text-center font-weight-bold w-100">
                  Información General
                </h1>
              </div>
              <div class="card-body text-secondary text-sm">
                <p><b>Cliente: </b> {{cliente.name}}</p>
                <p><b>Pautas activas: </b> {{agendas.length}}</p>
                <div v-for="agenda in agendas" :key="agenda.id">
                  <small class="ml-2"><b>Título: </b>{{agenda.title}} - {{agenda.npantallas + " pantallas"}}</small>
                  <br>
                  <small class="ml-2"><b>Vendedor: </b>{{agenda.vendedor}}</small>
                  <br>
                  <small>
                  <span class="ml-2"><b>Desde: </b>{{agenda.start}} - <b>Hasta:</b>{{agenda.end}}</span>
                  </small>
                  <br>
                  <p class="text-xs text-left pl-2"><a href="#" v-on:click="buscarEvento(agenda.id)">Editar</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  

    <!-- modal form -->
    <div class="modal fade" id="articuloModal" tabindex="-1" role="dialog" aria-labelledby="articuloModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-uppercase" id="articuloModalLabel">{{tituloform}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body pb-0">
            <div class="form-group">
              <label>Título para la pauta: </label>
              <input type="text" v-model="titulo" class="form-control">
            </div>
            <div class="form-group">
              <label>Pantallas: </label>
              <multiselect  v-model="value" deselect-label="remover" selected-label="Seleccionado" select-label="Presiona para agregar" track-by="name" label="name" placeholder="Seleciona una pantalla" :options="options" :searchable="true" :multiple="true">
              </multiselect>
               <!-- <pre class="language-json"><code>{{ vendedor  }}</code></pre> -->
            </div>
            <div class="row">
              <div class="col">
                <label>Fecha inicio:</label>
                <input type="date" v-model="startdate"  class="form-control">
              </div>
              <div class="col">
                <label>Fecha fin:</label>
                <input type="date" v-model="enddate" class="form-control">
              </div>
            </div>
            <p class="p-0 mt-4 mb-0" v-if="vendedor.length > 0"><span class="badge badge-pill badge-light"><b>Cliente: </b>{{cliente.name}}</span> <span class="badge badge-pill badge-light" v-for="item in vendedor" :key="item.id"><b>Vendedor: </b> {{item.vendedor}}</span></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" @click="updateOrCreateEvent()">Guardar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- end modal -->
  </div>
</template>

<script>
import EventBus from '../eventbus.js';  
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin, {Draggable} from "@fullcalendar/interaction";

// must manually include stylesheets for each plugin
import "@fullcalendar/core/main.css";
import "@fullcalendar/daygrid/main.css";
import "@fullcalendar/timegrid/main.css";

export default {
  components: {
    FullCalendar// make the <FullCalendar> tag available
  },
  props:['cliente','npantallas'],
  data: function() {
    return {
        titulo: '',
        evento: '',
        search:'',
        startdate: '',
        enddate: '',
        tituloform: '',
        value: [],
        agendas:[],
        options: [],
        vendedor:'',
      calendarPlugins: [
        // plugins must be defined in the JS
        dayGridPlugin,
        timeGridPlugin,
        interactionPlugin // needed for dateClick
      ],
      calendarWeekends: true,
      update: false,
    };
  },
  methods: {
        getAgenda(){
            let vm = this
            axios.get("/mediacam/listpautas/"+vm.cliente.id).then(({data})=>{
              vm.agendas = data.data
            })
        },
        getPantallas(){
          let vm  = this
          axios.get("/mediacam/apipantallas").then(({data})=>{
            vm.options = data
          })
        },
        getPantallasevento(pantalla){
          let vm = this
          axios.get("/mediacam/pautas/" + pantalla).then(({data})=>{
            vm.value = data.data
          })
        },
        viewEvent(data){
            let vm = this
            vm.getPantallasevento(data.event.id)
            vm.tituloform = "Editar Pauta"
            vm.update = true
            vm.titulo = data.event.title
            vm.evento = data.event.id
            vm.vendedor = vm.agendas.filter(function(agenda) {
              return agenda.id == data.event.id
            })
            vm.startdate = moment(data.event.start).format('YYYY-MM-DD')
            vm.enddate = moment(data.event.end).format('YYYY-MM-DD')
            $("#articuloModal").modal('show');
        },
        eventResize(pauta){
          this.evento = pauta.event.id
          this.titulo = pauta.event.title
          this.startdate = pauta.event.start
          this.enddate = pauta.event.end
          this.getPantallas(this.evento)
          this.updateOrCreateEvent();
        },
        updateOrCreateEvent(){
          let vm = this
          var miarray = []
          for(var i = 0; i < this.value.length; i++){
              miarray.push(this.value[i].id)
          }

          if(vm.evento == "")
          {
            if(vm.value.length > 0)
            {
              axios.post("/mediacam/pautas/",{
                titulo: vm.titulo,
                start_date: vm.startdate,
                end_date: vm.enddate,
                pantallas: miarray,
                cliente_id: vm.cliente.id,
              }).then(({data})=>{
                $("#articuloModal").modal('hide');
                toastr.success("¡Tu pauta ha sido guardada con éxito!");
                vm.clear()
                vm.getAgenda()
              })
            }else
            {
              toastr.warning("¡Debes seleccionar al menos una pantalla!")
            }
          }
          else
          {
            axios.put("/mediacam/pautas/" + vm.evento,{
              titulo: vm.titulo,
              start_date: vm.startdate,
              end_date: vm.enddate,
              pantallas: miarray,
              cliente_id: vm.cliente.id,
            }).then(({data})=>{
               $("#articuloModal").modal('hide');
                toastr.success("¡Tu pauta se actualizó con éxito!");
                vm.clear()
                vm.getAgenda()
            })
          }
        },
        dropEvent(info){
            
        },
        handleDateClick(pauta) {
          let vm = this
          vm.update = false
          vm.clear()
          vm.startdate = moment(pauta.dateStr).format('YYYY-MM-DD')
          vm.enddate = moment(pauta.dateStr).add(1, 'days').format('YYYY-MM-DD')
          vm.tituloform = "Nueva Pauta para " + vm.cliente.name
          $("#articuloModal").modal('show');
        },
        buscarEvento(evento){
          var calendarApi = this.$refs.fullCalendar.getApi()
          var event = calendarApi.getEventById(evento)
          this.tituloform = "Editar Pauta"
          this.evento = event.id
          this.titulo = event.title
          this.startdate = moment(event.start).format('YYYY-MM-DD')
          this.enddate = moment(event.end).format('YYYY-MM-DD')
          this.getPantallasevento(event.id)
          $("#articuloModal").modal('show');
        },
        clear(){
          this.value = []
          this.titulo = ''
          this.vendedor = []
          this.evento = ''
          this.startdate = ''
          this.enddate = ''
        }
    },

    computed:{
        updateAgenda(){
          return this.agendas
        },

        updateEtiquetas(){
          return this.etiquetas
        },
    },

    mounted(){
        this.getAgenda();
        this.getPantallas();
        let calendarApi = this.$refs.fullCalendar.getApi()
        calendarApi.setOption('locale','es')
    }
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
  .multiselect__tag{
    background-color: #FF5733;
  }
  .multiselect__tag-icon:hover{
    background-color: #FF5733;
  }
</style>