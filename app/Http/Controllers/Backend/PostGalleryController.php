<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostGallery;
use App\Repositories\PostGalleryRepository;
use App\Contracts\WebSite\PostGalleryContract;
use Validator, Storage;

class PostGalleryController extends Controller
{
   
    public $postGalleryRepository, $service;

    public function __construct(PostGalleryRepository $postGalleryRepository, PostGalleryContract $service)
    {
        $this->postGalleryRepository = $postGalleryRepository;
        $this->service = $service;
    }
   
     /**
     * Store a Gallery File resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeFile(Request $request)
    {
      
        $validator = Validator::make($request->all(), 
                [ 
                'file' => 'required|mimes:png,jpg|max:12048',
                ]);   
    
                $this->service->storeImage($request->file('file'));  

                $fill = $request->all();

                $fill['image'] = $this->service->getImageNameWithJPGExtension($request->file('file'));

                $fill['post_id'] = $request->get('id'); 

                $postGallery = new PostGallery();

                $postGallery->fill($fill);

                $this->postGalleryRepository->save($postGallery);
    
                
                return response()->json([
                    "success" => true,
                    "message" => "File successfully uploaded",
                ]);        
  
    }

    /**
     * Store a Gallery File resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeVideoId(Request $request)
    {               
                
        $fill = $request->all();

        $this->service->storeVideoImage($fill['video_id']);

        $fill['image'] = $this->service->getThumbnailVideoImageName($fill['video_id']);

        $fill['post_id'] = $request->get('id');

        $postGallery = new PostGallery();

        $postGallery->fill($fill);

        $this->postGalleryRepository->save($postGallery);
        
        return response()->json([
            "success" => true,
            "message" => "File successfully uploaded"
        ]);         
 
  
    }


    /**
     * Remove the specified postGallery resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyFile(Request $request,$id)
    {
        try {
            
            $postGallery = postGallery::findOrFail($id);
            
            if($postGallery->imagen){

                Storage::disk('public')->delete('post/gallery/'.$postGallery->imagen);
                Storage::disk('public')->delete('post/gallery/thumb'.$postGallery->imagen);
            }

            $this->postGalleryRepository->delete($postGallery);

            return redirect()->route('admin.posts.edit', $request->input('id'))
                ->withFlashSuccess('La imagen se eliminó correctamene');

        } catch(ModelNotFoundException $e) {

            return redirect()->route('admin.posts.index')
                ->withFlashWarnig('No se encontró el registro a borrar');
        }
    }

    /**
     * Display a listing of the Gallery resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMedia($id)
    {	
    	$postsGallery = $this->postGalleryRepository->allByPostId($id);
        $postsGalleryArray = []; 
        foreach ($postsGallery as $postGallery) {            

            $postsGalleryArray[] = ['id' => $postGallery->id , 'post_id' => $postGallery->post_id, 'position' => $postGallery->position, 'image' => $postGallery->image, 'link_video' => $postGallery->link_video];

            
        }
    	return response()->json($postsGalleryArray); 
    	
    }

    
}
