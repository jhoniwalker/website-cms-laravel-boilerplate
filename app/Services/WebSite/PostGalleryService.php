<?php

namespace App\Services\WebSite;

use App\Contracts\WebSite\PostGalleryContract;

use Image;

class PostGalleryService extends BaseService implements PostGalleryContract
{

   CONST ATTRIBUTES = [
    'width_resize_original_image' => 800,
    'height_resize_original_image' => null,
    'width_fit_thumbnail_image' => 271,
    'height_fit_thumbnail_image' => 181,
    'path_original_image' => 'storage/post/gallery/',
    'path_thumbnail_image' => 'storage/post/gallery/thumbnail/',
    'quality_image' => 90 
];

    public function __construct()
    {
        parent::__construct(self::ATTRIBUTES);
    }

    public function storeVideoImage($videoId)
    { 
        $thumbnailVideoImageName = $this->getThumbnailVideoImageName($videoId);

        $image = Image::make("https://img.youtube.com/vi/".$videoId."/hqdefault.jpg");
        
        $this->storeThumbnailVideoImage($image, $thumbnailVideoImageName);


    }
    
    public function getThumbnailVideoImageName($videoId)
    { 
        return 'img_youtube_'.$videoId.'.jpg';
    }

    public function storeThumbnailVideoImage($image, $thumbnailVideoImageName)
    {
        //generate original image path
        $thumbPath = public_path(self::ATTRIBUTES['path_thumbnail_image'].$thumbnailVideoImageName);
        
        $image->fit(373, 273);

        $image->save($thumbPath);
    }
}