<!--GALLERY-->
<div style="padding-top:100px; margin-top:-100px" id="gallery-content">
  <strong>Galería</strong>
  <hr> 

  <div id="menu-gallery"
    data-menu-id={{$menu->id}}
    data-menu-gallery={{$menuGallery}}
    data-csrf-token={{ csrf_token() }}
    data-post-store="{{ route('admin.menus.store-file') }}"
    data-post-store-video-id="{{ route('admin.menus.store-video-id') }}"
    data-get-media="{{ route('admin.menus.get-media', $menu->id) }}"
  >
    
  </div>
</div>