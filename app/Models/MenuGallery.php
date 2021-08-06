<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuGallery extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menus_gallery';

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
        'menu_id',
        'image',
        'video_id',
        'position'
        
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
      

}
