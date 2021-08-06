<div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
    @if ($menu->type === 'pagina')
        <a href="#gallery-content" class="btn btn-info ml-1" data-toggle="tooltip" title="Galería"><i
                class="fas fa-photo-video"></i></a>
        <a href="{{ route('frontend.contenidos.show', ['slug' => $menu->slug]) }}" class="btn btn-info ml-1"
            data-toggle="tooltip" title="Ver en una nueva ventana" target="_blank" rel="noreferer noopener"><i
                class="fa fa-external-link-alt fa-fw"></i></a>

    @endif
    <a href="{{ route('admin.menus.index') }}" class="btn btn-info ml-1" data-toggle="tooltip"
        title="Mostrar todos"><i class="fas fa-list"></i></a>
</div>
<!--btn-toolbar-->
