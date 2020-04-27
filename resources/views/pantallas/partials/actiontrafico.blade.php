    <div class="btn-group ">
        <a href="{!!$addArticle!!}" title="Agregar pautas"  class="btn btn-sm btn-publimovil" role="button" aria-pressed="true"><i class="fa fa-desktop" aria-hidden="true"></i> Pautas</a>
        @if(Auth::user()->role_id == 4 || Auth::user()->role_id == 1)
        <a href="{!!$editClient!!}" title="Editar artículos"  class="btn btn-sm btn-warning ml-1" role="button" aria-pressed="true"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
        @endif
    </div>