@extends('backend.layouts.app')

@section('content')
<form role="form" method="POST" class="form-with-dropzone dz-clickable" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
    <div class="card">
        <div class="card-header">
            <strong>Post</strong>
            <small>New post</small>
            <div class="btn-group btn-group-sm float-right">
              @include('backend.posts.includes.header-create-button')
            </div>
        </div>
        <div class="card-body">
          <div class="row mt-4 mb-4">
            <div class="col">

                @include('backend.posts.fields')

            </div>
          </div>
      </div>

      <div class="card-footer">
        <button class="btn btn-sm btn-success" type="submit">
            <span class="fa fa-check"></span> Save
        </button>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-secondary">
            <span class="fa fa-undo"></span> Cancel
        </a>
      </div>
    </div>
</form>
@endsection
