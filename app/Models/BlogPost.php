<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'body', 'author_id', 'id'];

    // this function defines the relationship between BlogPost class (model) and the BlogComment class (model)
    public function blogComments()
    {
        return $this->hasMany(BlogComment::class, 'comment_post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'author_id','id');
    } 

    public function tags() 
    {
        return $this->belongsToMany(Tag::class, 'blog_post_tag');
    }
}