<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use Sluggable;
     /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true,
            ]
        ];
    }
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'parent',
        //'slug',
        'type',
        'image',
        'title',
        'intro',
        'body',
        'link',
        'target',                
        'published',
        'issyst',           
        'position',
        'onmenu',
        'onfooter',
        'onheader'    
        
    ];

    public function getChildren($data, $line)
    {
        $children = [];
        foreach ($data as $line1) {
            if ($line['id'] == $line1['parent']) {
                $children = array_merge($children, [ array_merge($line1, ['submenu' => $this->getChildren($data, $line1) ]) ]);
            }
        }
        return $children;
    }
    /**
     * Para el menu del frontend
     */
    public function optionsMenu()
    {
        return $this->select('id','parent','name','type','slug','link','target')
            ->where('published', 1)
            ->where('onmenu', 1)
            ->orderby('parent')
            ->orderby('position')
            ->orderby('name')
            ->get()
            ->toArray();
    }

    public static function menus()
    {
        $menus = new Menu();
        $data = $menus->optionsMenu();
        $menuAll = [];
        foreach ($data as $line) {
            $item = [ array_merge($line, ['submenu' => $menus->getChildren($data, $line) ]) ];
            $menuAll = array_merge($menuAll, $item);
        }
        return $menus->menuAll = $menuAll;
    }


    /**
     * Para el index del backend
     */

    public function optionsMenuIndex()
    {
        return $this->select('id','parent','name','type','slug','link','target', 'published', 'onmenu', 'onfooter', 'onheader')            
            ->orderby('parent')
            ->orderby('position')
            ->orderby('name')
            ->get()
            ->toArray();
    }

    public static function menusIndex()
    {
        $menus = new Menu();
        $data = $menus->optionsMenuIndex();
        $menuAll = [];
        foreach ($data as $line) {
            $item = [ array_merge($line, ['submenu' => $menus->getChildren($data, $line) ]) ];
            $menuAll = array_merge($menuAll, $item);
        }
        return $menus->menuAll = $menuAll;
    }

    //Gallery
    public function menuGallery()
    {
         return $this->hasMany(MenuGallery::class)->orderBy('position');
    }

    //aumento la posición al guardar
    protected static function boot()
    {
        parent::boot();

        Menu::creating(function ($model) {
            //si es parte del menu, ni footer y encabezado
            if ($model->onmenu == 1 || $model->onfooter == 1 || $model->onheader == 1){

                if($model->parent == 0){
                    
                    $model->position = Menu::where('parent',0)->where('onmenu', 1)->max('position') !== null? Menu::where('parent',0)->where('onmenu', 1)->max('position') + 1 : 0;
               
                }else{
                
                    $model->position = Menu::where('parent', $model->parent)->max('position') !== null? Menu::where('parent', $model->parent)->max('position') + 1 : 0;
                }

            }else{
                //si no es parte del menu le doy un numero muy grande
                $model->position = 500;

            }
            
           
        });
    }
      

}
