<div class="table-responsive">
  <table class="table" id="myDataTable">
    <thead>
      <th></th>
      <th>Nombre</th>
      <th>Tipo</th>
      <th>Publicado</th>
      <th>Submenus</th>
      <th>Acciones</th>
    </thead>
    <tbody>
     
      @foreach ($menus as $key => $menu)
        @if ($menu['parent'] != 0)
          @break
        @endif
        @include('backend.menus.includes.table-row', [ 'menu' => $menu ]) 
			@endforeach      
    </tbody>
  </table>
</div>
