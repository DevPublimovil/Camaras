<div class="modal fade" id="editclient" tabindex="-1" role="dialog" aria-labelledby="labeleditclient" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content modal-publimovil">
        <div class="modal-header">
          <h5 class="modal-title" id="labeleditclient">Nuevo cliente</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:aliceblue">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{route('clients.update', $user->id)}}" method="POST">
              @csrf
              <input type="hidden" name="_method" value="PUT">
              <div class="form-group">
                <label for="tiempo_vida">Fecha de vencimiento</label>
                <input type="date" name="tiempo_vida" id="time" class="form-control form-control-pu" value="{{$user->fecha_fin}}">
              </div>
              <div class="form-group text-center">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-sm btn-publimovil">Guardar</button>
              </div>
          </form>
        </div>
      </div>
    </div>
</div>