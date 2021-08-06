@if ($menu['submenu'] == [])
    <tr data-id={{ $menu['id'] }} class="{{ $menu['onmenu'] == 1 ? 'table-info' : '' }}">
        <td class="text-center align-middle cursor-move">
            @if ($menu['onmenu'] == 1 || $menu['onfooter'] == 1 || $menu['onheader'] == 1)<i
                    class="fas fa-arrows-alt"></i>@endif
        </td>
        <td><span class="d-inline-block text-truncate" style="max-width: 150px;">{{ $menu['name'] }}</span></td>
        <td>{{ $menu['type'] }}</td>
        {{-- <td>{{ $menu->find($menu->parent)? $menu->find($menu->parent)->name: 'Ninguno' }}</td> --}}
        <td>
            <div class='btn-group'>
                <form method="POST" action="{{ route('admin.menus.published', $menu['id']) }}">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}
                    <label class="c-switch c-switch-label c-switch-primary">
                        <input type="hidden" name="published" value="off" />
                        <input class="c-switch-input" type="checkbox" onClick="this.form.submit()" name="published"
                            {{ $menu['published'] == 1 ? ' checked' : '' }}>
                        <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                    </label>
                </form>
            </div>
        </td>
        <td>
            @if ($menu['onmenu'] == 1 || $menu['onfooter'] == 1 || $menu['onheader'] == 1)
                <button type="button" class="btn btn-primary btn-sm" disabled>
                    <i class="fas fa-list-ul"></i>
                </button>
            @endif
        </td>
        <td>
            <div class='btn-group'>
                <form method="POST" action="{{ route('admin.menus.destroy', $menu['id']) }}">
                    {!! csrf_field() !!}
                    {{ method_field('DELETE') }}

                    <a href="{{ route('admin.menus.edit', $menu['id']) }}" class='btn btn-primary btn-sm'>
                        <span class="fas fa-edit"></span>
                    </a>

                    <button class="btn btn-danger btn-sm" type="submit"
                        onclick="return confirm('¿Estás seguro de borrar el registro?')">
                        <span class="fas fa-trash"></span>
                    </button>

                    @if ($menu['onmenu'] == 1)
                        <a href="#" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left"
                            title='Es parte del menu'>
                            <i class="fas fa-info"></i>
                        </a>
                    @endif

                </form>
            </div>

        </td>
    </tr>
@else
    <tr data-id={{ $menu['id'] }}
        class="{{ $menu['type'] !== 'menu superior' ? 'table-warning' : 'table-info' }}">
        <td class="text-center align-middle cursor-move"><i class="fas fa-arrows-alt"></i></td>
        <td><span class="d-inline-block text-truncate" style="max-width: 150px;">{{ $menu['name'] }}</span> <i
                class="fas fa-caret-down"></i></td>
        <td>{{ $menu['type'] }}</td>
        {{-- <td>{{ $menu->find($menu->parent)? $menu->find($menu->parent)->name: 'Ninguno' }}</td> --}}
        <td>
            <div class='btn-group'>
                <form method="POST" action="{{ route('admin.menus.published', $menu['id']) }}">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}
                    <label class="c-switch c-switch-label c-switch-primary">
                        <input type="hidden" name="published" value="off" />
                        <input class="c-switch-input" type="checkbox" onClick="this.form.submit()" name="published"
                            {{ $menu['published'] == 1 ? ' checked' : '' }}>
                        <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                    </label>
                </form>
            </div>
        </td>
        <td>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                data-target="#exampleModalCenter{{ $menu['id'] }}">
                <i class="fas fa-list-ul"></i>
            </button>
        </td>
        <td>
            <div class='btn-group'>
                <form method="POST" action="{{ route('admin.menus.destroy', $menu['id']) }}">
                    {!! csrf_field() !!}
                    {{ method_field('DELETE') }}

                    <a href="{{ route('admin.menus.edit', $menu['id']) }}" class='btn btn-primary btn-sm'>
                        <span class="fas fa-edit"></span>
                    </a>

                    {{-- <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('¿Estás seguro de borrar el registro?')">
              <span class="fas fa-trash"></span>
            </button> --}}

                    @if ($menu['type'] !== 'menu superior')
                        <a href="#" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left"
                            title='Un menu con submenues debe ser de tipo "menu superior" para una mayor experiecia de usuarios en dispositivos móviles'>
                            <i class="fas fa-exclamation"></i>
                        </a>
                    @endif
                    @if ($menu['onmenu'] == 1)
                        <a href="#" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left"
                            title='Es parte del menu'>
                            <i class="fas fa-info"></i>
                        </a>
                    @endif
                </form>
            </div>
        </td>
    </tr>
    <!--Modal-->
    <div class="modal fade" id="exampleModalCenter{{ $menu['id'] }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Submenus de {{ $menu['name'] }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach ($menu['submenu'] as $submenu)
                        @if ($submenu['submenu'] == [])
                            <div class="row">
                                <div class="col-md-3"><i class="fas fa-arrow-right"></i> {{ $submenu['name'] }}</div>
                                <div class="col-md-3">{{ $submenu['type'] }}</div>
                                <div class="col-md-3">
                                    <div class='btn-group'>
                                        <form method="POST"
                                            action="{{ route('admin.menus.published', $submenu['id']) }}">
                                            {!! csrf_field() !!}
                                            {{ method_field('PUT') }}
                                            <label class="c-switch c-switch-label c-switch-primary">
                                                <input type="hidden" name="published" value="off" />
                                                <input class="c-switch-input" type="checkbox"
                                                    onClick="this.form.submit()" name="published"
                                                    {{ $submenu['published'] == 1 ? ' checked' : '' }}>
                                                <span data-toggle='tooltip' title="Publicar/Despublicar"
                                                    class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                            </label>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class='btn-group'>
                                        <form method="POST"
                                            action="{{ route('admin.menus.destroy', $submenu['id']) }}">
                                            {!! csrf_field() !!}
                                            {{ method_field('DELETE') }}

                                            <a href="{{ route('admin.menus.edit', $submenu['id']) }}"
                                                class='btn btn-primary btn-sm' data-toggle="tooltip" title="Editar">
                                                <span class="fas fa-edit"></span>
                                            </a>

                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" type="submit"
                                                onclick="return confirm('¿Estás seguro de borrar el registro?')"
                                                title="Eliminar">
                                                <span class="fas fa-trash"></span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @else
                            @include('backend.menus.includes.table-row', [ 'menu' => $submenu ])
                        @endif
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

@endif
