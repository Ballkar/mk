<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'blog_categories';
    protected $guarded = [];


    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
