<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
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
                'source' => 'title',
                'onUpdate' => true,
            ]
        ];
    }
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

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
        'post_category_id',                
        'title',
        'intro',
        'body',
        'image',
        'published',
        'featured', 
        //readings       
    ];

    public function postCategory()
    {
        return $this->belongsTo(PostCategory::class);
    }

    //Gallery
    public function postGallery()
    {
         return $this->hasMany(PostGallery::class)->orderBy('position');
    }
    
    /**
     * Filter
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIndexFilter($query)
    {
        if (request('title')) {
            
            $query->where('title', 'like', '%'.request('title').'%');
        }
        

        if (request('published')) {
            $query->where('published', '=', request('published'));
        }

        if (request('featured')) {
            $query->where('featured', '=', request('featured'));
        }

        $query->orderby('created_at', 'desc');
        
        return $query;
    }

}
