{!! csrf_field() !!}
<div class="row">
    <div class="col-sm-6">
        <strong>Basic data</strong>
        <hr>
    
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
                            {{ $post->published == 1 ? ' checked' : '' }}>
                        <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <label for="outstanding">Stand out</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <input type="hidden" name="outstanding" value="0" />
                    <label class="c-switch c-switch-label c-switch-primary">
                        <input class="c-switch-input" type="checkbox" name="outstanding" id="outstanding" value="1"
                            {{ $post->outstanding == 1 ? ' checked' : '' }}>
                        <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <strong>Principal photo</strong>
        <hr>
        <div class="form-group ">

            @if ($post->image)
                <div class="d-flex">
                    <img class="img-thumbnail" src={{ Storage::disk('local')->url('post/thumbnail/' . $post->image) }}
                        style="width: 150px; background-size: contain ; background-repeat: no-repeat height: 150px;">
                    <div class="d-flex flex-column ml-2">
                        <div class="d-flex align-items-baseline">
                            <a href={{ Storage::disk('local')->url('post/' . $post->image) }} target="_blank"
                                rel="noreferer noopener" class="btn btn-outline-primary btn-sm btn-block">
                                <i class="fa fa-external-link-alt fa-fw"></i> Original
                            </a>
                            <!--<a href="" data-method="delete" data-token={{ csrf_token() }} data-confirm="Borrar imagen?" class="btn btn-danger btn-sm ml-1 btn-block">
              <i class="fa fa-trash fa-fw"></i> Eliminar
            </a>-->
                        </div>
                        <div class="form-group ">
                            <label for="logo">Image (You can change de image)</label>
                            <input type="file" name="image" class="form-control" id="image">

                        </div>
                    </div>
                </div>
            @else
                <label for="image">Image</label>
                <input type="file" required name="image" class="form-control" id="image" accept="image/*">
            @endif
        </div>
        <!--<div id="dropzone_image">
      
    </div> -->
    </div>
</div>
<strong>Content</strong>
<hr>
<div class="form-group">
    <label for="title">Title</label>
    <input class="form-control" required name="title" id="title" type="text" value="{{ old('title', $post->title) }}">
</div>
<div class="form-group">
    <label for="intro">Intro</label>
    <textarea class="form-control" required name="intro" id="intro"
        type="text">{{ old('intro', $post->intro) }}</textarea>
</div>
<div class="form-group">
    <label for="body">Body</label>
    <div id="tiny_editor" data-content="{{ old('body', !is_null($post->body) ? $post->body : '') }}"
        data-textarea-name="body">
    </div>
</div>
