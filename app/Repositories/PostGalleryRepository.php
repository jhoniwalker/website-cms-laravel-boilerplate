<?php

namespace App\Repositories;

use App\Models\PostGallery;

class PostGalleryRepository extends BaseRepository
{


    public function __construct(PostGallery $postGallery)
    {
        parent::__construct($postGallery);
    }

    
    public function allByPostId($id)
    {
        return $this->model->where('post_id', $id)->orderBy('position')->get();
    }


}