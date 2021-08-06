<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuGallery;
use Validator, Storage, Image;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(Menu::where('parent',0)->max('position'));

        return view('backend.menus.index')->with('menus', Menu::menusIndex());

    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.menus.create')
            ->with('menu', new Menu())
            ->with('menus', Menu::where('parent','=', 0)->where('onmenu', 1)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fill = $request->all();
        $menu = new Menu();
        if(!is_null($request->file('image'))){   
                        
            ini_set('memory_limit','256M');
            $imageName = $request->file('image')->getClientOriginalName(); 
            //$imageExtension = $request->file('image')->extension();
            //$imageHash = md5($imageName).'.'.$imageExtension;
            $imageNameExtension = $imageName;

            $image = Image::make($request->file('image'));
            
            //guardo imagen del menu
            $originalPath = public_path('storage/menu/'.$imageNameExtension);
           
            //hago redimención restringiendo relación de aspecto
            $image->resize(968, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image->save($originalPath);

            $fill['image'] = $imageNameExtension;//$imageHash;
        }
        $menu->fill($fill);
        $menu->save();

        return redirect()->route('admin.menus.edit', $menu->id)
            ->withFlashSuccess('El registro fue agregado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            return view('backend.menus.edit')
                ->with('menu', Menu::findOrFail($id))
                ->with('menus', Menu::where('id', '!=', $id)->where('parent','=', 0)->where('onmenu', 1)->get())
                ->with('menuGallery', MenuGallery::where('menu_id', $id)->orderBy('position')->get());
    

        } catch(ModelNotFoundException $e) {

            return redirect()->route('admin.menus.index')
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
        /*$menus = Menu::all();
        foreach ($menus as $command)
        {
            $command->update();
        }*/
        try {
            $data = $request->all();
            $menu = Menu::findOrFail($id);

            if(!is_null($request->file('image'))){

                ini_set('memory_limit','256M');
                Storage::disk('public')->delete('menu/'.$menu->image);               

                $imageName = $request->file('image')->getClientOriginalName(); 
                //$imageExtension = $request->file('image')->extension();
                //$imageHash = md5($imageName).'.'.$imageExtension;
                $imageNameExtension = $imageName;

                $image = Image::make($request->file('image'));
            
                 //guardo imagen del manu
                $originalPath = public_path('storage/menu/'.$imageNameExtension);
           
                //hago redimención restringiendo relación de aspecto
                $image->resize(968, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $image->save($originalPath);

                $data['image'] = $imageNameExtension;
            }

            /** 
             * Acodomo las posiciones de contenidos 
             * publicados o no              
             */
            //si es parte del menu, footer o encabezado
            if ($data['onmenu'] == 1 || $data['onfooter'] == 1 || $data['onheader'] == 1){
                
                //si no era parte del menu, footer o encabezado, modifico su position
                if($menu->position >= 500){

                    if($data['parent'] == 0){
                        
                        $data['position'] = Menu::where('parent',0)->where('onmenu', 1)->max('position') !== null? Menu::where('parent',0)->where('onmenu', 1)->max('position') + 1 : 0;
                    
                    }else{
                    
                        $data['position'] = Menu::where('parent', $data['parent'])->max('position') !== null? Menu::where('parent', $data['parent'])->max('position') + 1 : 0;
                    }
                }   

            }else{
                //si no es parte del menu le doy un numero muy grande
                $data['position'] = 500;

            }

            $menu->update($data);

            /**
             * Obtengo los id (images_id[]) de las imágenes desde SortableGallery.js. 
             * Recorro el arreglo y por cada id que recorro primero le actualizo la position
             * Ej: id=>234, position=>1, id=>232, position=>2, etc.
             * 
             */
            if($request->has('images_id')){
                $position = 0;

                foreach($data['images_id'] as $imageID){
                    MenuGallery::where('menu_id', $id)
                    ->where('id', $imageID)
                    ->update([
                        'position' => $position 
                    ]);

                    $position++;
                }
            }

            return redirect()->route('admin.menus.edit', $id)
                ->withFlashSuccess('El registro se editó correctamente');

        } catch(ModelNotFoundException $e) {

             return redirect()->route('admin.menus.index')
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

            $menu = menu::findOrFail($id);

            Storage::disk('public')->delete('menu/'.$menu->image);

            //Se debe implementar Eliminar los hijos si el parent === 0

            $menu->delete();

            return redirect()->route('admin.menus.index')
                ->withFlashSuccess('El registro se borró correctamente');

        } catch(ModelNotFoundException $e) {

            return redirect()->route('admin.menus.index')
                ->withFlashWarnig('No se encontró el registro a borrar');
        }
    }

    /**
     * Update published record from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function published($menuId){

        $menu = menu::findOrFail($menuId);

        $menu->update((array('published' => !$menu->published)));
 
        return redirect()->route('admin.menus.index')
             ->withFlashSuccess('El registro se editó correctamente');
    }

    /**
     * Store a Gallery File resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeFile(Request $request)
    {
       //dd($request->all());
       ini_set('memory_limit','256M');
        $validator = Validator::make($request->all(), 
                [ 
                'file' => 'required|mimes:png,jpg|max:12048',
                ]);   
    
        
                $imageName = $request->file('file')->getClientOriginalName(); 
                //$imageExtension = $request->file('file')->extension();
                //$imageHash = md5($imageName).'.'.$imageExtension;
                $imageNameExtension = $imageName;
                $image = Image::make($request->file('file'));
                
                //guardo imagen semi original - reduzco sus dimensiones
                $originalPath = public_path('storage/menu/gallery/'.$imageNameExtension);
                $image->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                }); 

                $image->save($originalPath);
                

                //guardo un thumbnail de la imagen
                $thumbPath = public_path('storage/menu/gallery/thumb/'.$imageNameExtension);

                //hago redimención y recorte del thumb
                $image->fit(271, 181);
                
                $image->save($thumbPath);
                
                
                
                $fill = $request->all();
                $fill['image'] = $imageNameExtension;

                $menuGallery = new MenuGallery();
                $menuGallery->fill($fill);
                $menuGallery->save();
                
                return response()->json([
                    "success" => true,
                    "message" => "File successfully uploaded",
                    "file" => $imageNameExtension
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
        /**guardar thumbnail de youtube*/
        ini_set('memory_limit','256M');
        $image = Image::make("https://img.youtube.com/vi/".$fill['video_id']."/hqdefault.jpg");
        $imageHash = 'img_youtube_'.$fill['video_id'].'.jpg';

        //guardo un thumbnail de la imagen
        $thumbPath = public_path('storage/menu/gallery/thumb/'.$imageHash);

        //hago redimención y recorte del thumb
        $image->fit(373, 273);
        
        $image->save($thumbPath);

        $fill['image'] = $imageHash;

        $menuGallery = new MenuGallery();
        $menuGallery->fill($fill);
        $menuGallery->save();
        
        return response()->json([
            "success" => true,
            "message" => "File successfully uploaded"
        ]);
         
 
  
    }

    /**
     * Remove the specified MenuGallery resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyFile(Request $request,$id)
    {
        try {
            
            $menuGallery = MenuGallery::findOrFail($id);
            
            if($menuGallery->imagen){

                Storage::disk('public')->delete('menu/gallery/'.$menuGallery->imagen);
                Storage::disk('public')->delete('menu/gallery/thumb'.$menuGallery->imagen);
            }

            $menuGallery->delete();

            return redirect()->route('admin.menus.edit', $request->input('menu_id'))
                ->withFlashSuccess('La imagen se eliminó correctamene');

        } catch(ModelNotFoundException $e) {

            return redirect()->route('admin.menus.index')
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
    	$menusGallery = MenuGallery::where('menu_id', $id)->orderBy('position')->get();
        $menusGalleryArray = []; 
        foreach ($menusGallery as $menuGallery) {            

            $menusGalleryArray[] = ['id' => $menuGallery->id , 'menu_id' => $menuGallery->menu_id, 'position' => $menuGallery->position, 'image' => $menuGallery->image, 'link_video' => $menuGallery->link_video];

            
        }
    	return response()->json($menusGalleryArray); 
    	
    }

     
    /**
     * Update position in storage. Reorder table.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function reorderTable(Request $request){

        foreach($request->input('result', []) as $row)
        {
            Menu::find($row['id'])->update([
                'position' => $row['position']
            ]);
        }

        return response()->noContent();
    }
         
}
