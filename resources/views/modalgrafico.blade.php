<div class="modal fade" id="graficoModal" tabindex="-1" role="dialog" aria-labelledby="graficoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="graficoModalLabel">Ver gráficas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('vistas.apiindex')}}" method="GET">
                @csrf
                <div class="form-group">
                    <label >País</label>
                    <select class="custom-select" name="pais">
                        <option value="1" @if($country == 1)selected @endif>El Salvador</option>
                        <option value="2" @if($country == 2)selected @endif>Guatemala</option>
                        <option value="4" @if($country == 4)selected @endif>Honduras</option>
                        <option value="6" @if($country == 6)selected @endif>Nicaragua</option>
                        <option value="3" @if($country == 3)selected @endif>Costa Rica</option>
                        <option value="5" @if($country == 5)selected @endif>Panama</option>
                    </select>
                </div>
                <div id="rango" v-if="rango == 1">
                    <div class="form-group">
                        <label for="fechauno">Desde</label>
                        <input type="date" class="form-control" name="fechauno" id="fechauno" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}">
                    </div>
                    <div class="form-group">
                        <label for="fechados">Hasta</label>
                        <input type="date" class="form-control" name="fechados" id="fechados" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}">
                    </div>
                </div>
                <div id="rango" v-if="rango == 0">
                    <div class="row form-group">
                        <div class="col-6">
                            <label for="">Fecha uno</label>
                            <input type="month" name="fechauno" class="form-control" id="mesuno" max="{{\Carbon\Carbon::now()->format('Y-m')}}" value="{{\Carbon\Carbon::now()->subMonth(1)->format('Y-m')}}">
                        </div>
                        <div class="col-6">
                            <label for="">Fecha dos</label>
                            <input type="month" class="form-control" name="fechados" id="mesdos" value="{{\Carbon\Carbon::now()->format('Y-m')}}">
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipo" id="rangos" checked value="1" @click="rango = 1 ">
                        <label class="form-check-label" for="rangos">Rango de fechas</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipo" id="comparar" value="2" @click="rango = 0">
                        <label class="form-check-label" for="comparar">Comparar fechas</label>
                      </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-sm btn-primary">Aceptar</button>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>