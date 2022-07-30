<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // belongs to many here for blogpost tag

    public function blogPost()
    {
        return $this->belongsToMany(BlogPost::class);
    }

}
