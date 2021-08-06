{!! csrf_field() !!}

<strong>Información básica</strong>
<hr>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control" required name="name" id="name" type="text"
                value="{{ old('name', $menu->name) }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="parent">Parent</label>
            <select class="form-control" required name="parent" id="parent">
                <option value="0" selected>None</option>
                @foreach ($menus as $menuItem)
                    <option value="{{ $menuItem->id }}" {{ $menuItem->id == $menu->parent ? 'selected' : '' }}>
                        {{ $menuItem->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <label for="published">Publish</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <input type="hidden" name="published" value="0" />
                    <label class="c-switch c-switch-label c-switch-primary">
                        <input class="c-switch-input" type="checkbox" name="published" id="published" value="1"
                            {{ $menu->published == 1 ? ' checked' : '' }}>
                        <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <label for="onmenu">Publish in menu</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <input type="hidden" name="onmenu" value="0" />
                    <label class="c-switch c-switch-label c-switch-primary">
                        <input class="c-switch-input" type="checkbox" name="onmenu" id="onmenu" value="1"
                            {{ $menu->onmenu == 1 ? ' checked' : '' }}>
                        <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <label for="onfooter">Publish in footer</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <input type="hidden" name="onfooter" value="0" />
                    <label class="c-switch c-switch-label c-switch-primary">
                        <input class="c-switch-input" type="checkbox" name="onfooter" id="onfooter" value="1"
                            {{ $menu->onfooter == 1 ? ' checked' : '' }}>
                        <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <label for="onheader">Publish upon of menu</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <input type="hidden" name="onheader" value="0" />
                    <label class="c-switch c-switch-label c-switch-primary">
                        <input class="c-switch-input" type="checkbox" name="onheader" id="onheader" value="1"
                            {{ $menu->onheader == 1 ? ' checked' : '' }}>
                        <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="menu_type" data-menu-type="{{ old('type', $menu->type != '' ? $menu->type : '') }}"
    data-link="{{ $menu->link }}" data-target="{{ $menu->target }}" data-title="{{ $menu->title }}"
    data-intro="{{ $menu->intro }}" data-body="{{ $menu->body }}"
    data-image="{{ $menu->image != '' ? Storage::disk('local')->url('menu/' . $menu->image) : '' }}">
    <!--Código o enlace-->
</div>
