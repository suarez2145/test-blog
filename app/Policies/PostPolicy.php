<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */

     // this new function uses the User and BlogPost models to get thier id and author_id fields and compare them to return a boolean and let blade know if the current users id matches the author_id 
    public function verify(User $user, BlogPost $post) {
        return $user->id === $post->author_id;
    }

    public function __construct()
    {
        //
    }


}
