@extends('backend.layouts.app')

@section('content')
    <form role="form" method="POST" action="{{ route('admin.posts.update', $post->id) }}" enctype="multipart/form-data">
      <div class="card">
        <div class="card-header">
          <strong>Post</strong>
          <small>Edit post</small>
          <div class="btn-group btn-group-sm float-right">
            @include('backend.posts.includes.header-edit-button')
          </div>
        </div>
        <div class="card-body">

          <div class="row mt-4 mb-4">
            <div class="col">
                {{ method_field('PUT') }}
                @include('backend.posts.fields')
                @include('backend.posts.includes.gallery')
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
@section('scripts')
<script type="text/javascript">
  $(document).on("click","a",function(e){
        var id = $(this).attr("href"),
            topSpace = 30;
        if(id === '#gallery-content'){
          $('html, body').animate({
            scrollTop: $(id).offset().top - topSpace
          }, 800);
        }
    });
</script>  
@endsection
