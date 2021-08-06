<?php

namespace App\Services\WebSite;

use App\Contracts\WebSite\PostContract;


class PostService extends BaseService implements PostContract
{

   const ATTRIBUTES = [
       'width_resize_original_image' => 968,
       'height_resize_original_image' => null,
       'width_fit_thumbnail_image' => 285,
       'height_fit_thumbnail_image' => 181,
       'path_original_image' => 'storage/post/',
       'path_thumbnail_image' => 'storage/post/thumbnail/',
       'quality_image' => 80 
   ];

    public function __construct()
    {
        parent::__construct(self::ATTRIBUTES);
    }
    

}