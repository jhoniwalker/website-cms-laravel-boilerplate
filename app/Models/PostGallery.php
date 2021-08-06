<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostGallery extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts_gallery';

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
        'post_id',
        'image',
        'video_id',
        'position'
        
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
      

}
