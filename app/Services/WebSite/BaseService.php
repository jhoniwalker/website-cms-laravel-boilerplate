<?php

namespace App\Services\WebSite;

use App\Contracts\WebSite\PostContract;

use Image;

class BaseService
{

    protected $attributes;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }
    
    public function storeImage($inputImage)
    { 
        $imageNameAndJPGExtension = $this->getImageNameWithJPGExtension($inputImage);

        $image = Image::make($inputImage)->encode('jpg');
        
        $this->storeOriginalImage($image, $imageNameAndJPGExtension);

        $this->storeThumbnailImage($image, $imageNameAndJPGExtension);

    }

    
    public function getImageNameWithJPGExtension($inputImage)
    {
        $imageNameWithExtension = $inputImage->getClientOriginalName(); 
        $imageName = pathinfo($imageNameWithExtension, PATHINFO_FILENAME); 
        return $imageName.'.'.'jpg';
    }


    public function storeOriginalImage($image, $imageNameAndJPGExtension)
    {
        //generate original image path
        $originalPath = public_path($this->attributes['path_original_image'].$imageNameAndJPGExtension);
        
        //hago redimención restringiendo relación de aspecto
        $image->resize($this->attributes['width_resize_original_image'], $this->attributes['height_resize_original_image'], function ($constraint) {
            $constraint->aspectRatio();
        });

        $image->save($originalPath);
    }

    public function storeThumbnailImage($image, $imageNameAndJPGExtension)
    {
         //generate thumbnail image path
         $thumbnailPath = public_path($this->attributes['path_thumbnail_image'].$imageNameAndJPGExtension);

         //hago redimención y recorte del thumbnail
         $image->fit($this->attributes['width_fit_thumbnail_image'],$this->attributes['height_fit_thumbnail_image']);
         
         $image->save($thumbnailPath, $this->attributes['quality_image']);
    }

}