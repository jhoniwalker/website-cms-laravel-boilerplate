<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostGallery;
use App\Repositories\PostRepository;
use App\Repositories\PostGalleryRepository;
use App\Contracts\WebSite\PostContract;
use App\Contracts\WebSite\PostGalleryContract;
use Validator, Storage;

class PostController extends Controller
{
   
    public $postRepository, $postGalleryRepository, $servive;

    public function __construct(PostRepository $postRepository, PostGalleryRepository $postGalleryRepository, PostContract $service)
    {
        $this->postRepository = $postRepository;
        $this->postGalleryRepository = $postGalleryRepository;
        $this->service = $service;
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        return view('backend.posts.index')
            ->with('posts', $this->postRepository->allWithFilter());

    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         
        return view('backend.posts.create')
            ->with('post', new post());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $request->validate([ 
            'title' => 'required', 
            'image' => 'required',
            'intro' => 'required',   
            'body' => 'required',
        ]);   

        $fill = $request->all();

        if(!is_null($request->file('image'))){   
                
            $this->service->storeImage($request->file('image')); 

            $fill['image'] = $this->service->getImageNameWithJPGExtension($request->file('image'));
        }

        $post = new post();

        $post->fill($fill);

        $this->postRepository->save($post);

        return redirect()->route('admin.posts.edit', $post->id)
            ->withFlashSuccess('El registro fue agregado correctamente');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        try {
            
            return view('backend.posts.edit')
                ->with('post', $post)
                ->with('gallery', $this->postGalleryRepository->allByPostId($post->id));
    

        } catch(ModelNotFoundException $e) {

            return redirect()->route('admin.posts.index')
                ->withFlashWarnig('No se encontró el registro a editar');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    
        try {

            $data = $request->all();

            $post = post::findOrFail($id);

            if(!is_null($request->file('image'))){
                
                Storage::disk('public')->delete('post/'.$post->image);
                Storage::disk('public')->delete('post/thumbnail/'.$post->image);               

                $this->service->storeImage($request->file('image'));  

                $data['image'] = $this->service->getImageNameWithJPGExtension($request->file('image'));
            }

            $post->fill($data);

            $this->postRepository->update($post);

            /**
             * update Gallery position
             */
            if($request->has('images_id')){
                $position = 0;

                foreach($data['images_id'] as $imageID){
                    PostGallery::where('post_id', $id)
                    ->where('id', $imageID)
                    ->update([
                        'position' => $position 
                    ]);

                    $position++;
                }
            }

            return redirect()->route('admin.posts.edit', $id)
                ->withFlashSuccess('El registro se editó correctamente');

        } catch(ModelNotFoundException $e) {

             return redirect()->route('admin.posts.index')
                ->withFlashWarnig('No se encontró el registro a editar');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $post = post::findOrFail($id);

            Storage::disk('public')->delete('post/'.$post->image);
            Storage::disk('public')->delete('post/thumbnail/'.$post->image);

            $this->postRepository->delete($post);

            return redirect()->route('admin.posts.index')
                ->withFlashSuccess('El registro se borró correctamente');

        } catch(ModelNotFoundException $e) {

            return redirect()->route('admin.posts.index')
                ->withFlashWarnig('No se encontró el registro a borrar');
        }
    }

    /**
     * Update records from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function tableSwitches(Request $request, $postId){
        try {

            $post = post::findOrFail($postId);

            if($request->has('published')){

                $post->update((array('published' => !$post->published)));

            }elseif($request->has('featured')){

                $post->update((array('featured' => !$post->featured)));

            }
 
            return redirect()->route('admin.posts.index')
                 ->withFlashSuccess('El registro se editó correctamente');

        }catch(ModelNotFoundException $e) {

            return redirect()->route('admin.posts.index')
                ->withFlashWarnig('No se encontró el registro a editar');
        }
    }
    
}
