<!--GALLERY-->
<div style="padding-top:100px; margin-top:-100px" id="gallery-content">
  <strong>Gallery</strong>
  <hr> 

  <div id="gallery"
    data-id={{$post->id}}
    data-gallery={{$gallery}}
    data-csrf-token={{ csrf_token() }}
    data-store-route="{{ route('admin.posts-gallery.store-file') }}"
    data-store-video-id-route="{{ route('admin.posts-gallery.store-video-id') }}"
    data-get-media-route="{{ route('admin.posts-gallery.get-media', $post->id) }}"
    data-destroy-route="{{ route('admin.posts-gallery.destroy-file') }}"
    data-storage-path="/storage/post/gallery/thumbnail/"
  >
    
  </div>
</div>