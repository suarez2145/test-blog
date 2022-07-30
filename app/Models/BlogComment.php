<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;
    protected $fillable = ['comment_txt','comment_post_id', 'author_id'];

    public function blogPost() 
    {
        return $this->belongsTo(BlogPost::class);
    }

    // this is allowing the comments model to reference the users table and associate the comments author_id with the users id
    // from this in our template we can access the users table with -> as part of our $comment variable
    public function user(){
        return $this->belongsTo(User::class,'author_id','id');
    }   

}