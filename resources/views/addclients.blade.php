<div class="modal fade" id="addclient" tabindex="-1" role="dialog" aria-labelledby="labeladdclient" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content modal-publimovil">
        <div class="modal-header">
          <h5 class="modal-title" id="labeladdclient">Nuevo cliente</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:aliceblue">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="@if(Auth::user()->hasPermission('list_clients_ventas') || Auth::user()->hasPermission('add_client_venta')) {{route('ventaspublimovil.store')}} @else {{route('trafico.store')}} @endif " method="POST">
              @csrf
              <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" class="form-control form-control-sm form-control-pu @error('name') is-invalid @enderror" required>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-group">
                <label for="email">Correo</label>
                <input type="email" name="email" id="email" class="form-control form-control-sm form-control-pu @error('email') is-invalid @enderror" required>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <input type="hidden" name="role_id" value="3">
              <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control form-control-sm form-control-pu @error('password') is-invalid @enderror" minlength="8" required>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-group">
                <label for="country_id">País</label>
                <select name="country_id" id="country_id" class="form-control form-control-pu">
                  @foreach ($paises as $pais)
                    <option value="{{$pais->id}}" @if($pais->id == Auth::user()->country_id) selected @endif @if(!Auth::user()->hasPermission('store_articles')) disabled @endif>{{$pais->name}}</option>
                  @endforeach
                </select>
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