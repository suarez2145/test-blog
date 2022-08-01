<?php

namespace App\Http\Controllers;
use App\Models\BlogPost;
use App\Models\BlogComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Tag;
use DB;


class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function cards()
    {
        $posts = BlogPost::all(); //fetch all blog posts from DB
        return view('blog.cards', [
            'posts' => $posts
        ]); //returns cards.blade.php by using view method 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Tag $tags) // passing in the Tag model vars as $tags
    {
        $tags = DB::table('tags')->get()->toArray(); // get the tags table info from the database with the get() method and save it as $tags variable
        
        $tagColors = array('primary','success','danger','dark', 'warning','info' );

        $newColors = array();

        foreach($tags as $tag) {
            
            $chsnClr = $tagColors[array_rand($tagColors)];
            array_push($newColors, $chsnClr);
            
        }
        
        
        return view('blog.create')->with('tags', $tags)->with('newColors', $newColors); //fetches the create view from the blog folder // also inserts the $tags variable to that view using the with() method


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, BlogPost $blogPost)
    {
        $this->validate($request, [
            'newTag' =>  'max:15', // this will make sure the incoming newTag input field is atleast 5 characters long IF NOT it will NOT save to database
        ]);

        $newPost = BlogPost::create([
            'title' => $request->title,
            'body' => $request->body,
            'author_id' => Auth::user()->id
        ]);

        $addTag = $request->get('newIpt');

        if ($request->get('newIpt')) {

            
            $addTag = $request->get('newIpt');
            

            foreach ($addTag as $tag) {            // this is looping through the tags in the input field the users added 
                $tagUppr = strtoupper($tag);
                $newTag = new Tag(['name' => $tagUppr]);
                $post = BlogPost::find($newPost->id);
                $post->tags()->save($newTag); 
            };

            $tagData = Tag::select('id', 'name') // this is retrieving the new tags that were saved into the database ABOVE line 66. It retrieves the tags with 'id' and 'name' attributes
            ->whereIn('name', $addTag)
            ->get();

            $tagDataId = $tagData->pluck('id')->toArray(); // this is retrieving the 'id' from the new tags we retrieved on line 73 

            

            $newPost->tags()->sync($request->tags);
            $newPost->tags()->syncWithoutDetaching($tagDataId);
    
            return redirect()->route('post-view',['blogPost' => $newPost->id]);
        } else {
                // if no newTag input then just save the new BlogPost
            $newPost->tags()->sync($request->tags);
            return redirect()->route('post-view',['blogPost' => $newPost->id]);
            
        }



        // $newTag = new Tag([...$addTag]);
        // dd($addTag);


        
        
    }

    //new view to create a commment for a blog

    public function create_comment()
    {
        return view('blog.create_comment'); //fetches the create view from the blog folder 
    }

    // new function to store the comment we just created 

    public function save(Request $request, $id)
    {   
        $this->validate($request, [
            'comment_txt' =>  'required|min:5', // this will make sure the incoming comment_txt field is atleast 5 characters long IF NOT it will NOT save to database
        ]);

        $newComment = BlogComment::create([
            'comment_txt' => $request->comment_txt,
            'comment_post_id' => $id,
            'author_id' => Auth::user()->id
        ]);


        
        // this is redirecting to the new comments post_id ** i will need to link this post id to an actual post because now its hard coded to 1 
        return redirect()->back()->with('success', 'comment created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function show(BlogPost $blogPost, Tag $tags ) // i had $id in this show function before adding BlogPost and Tag
    {
        $post = BlogPost::find($blogPost->id); // here i had only the $id variable to get current BlogPost id 

        $currentTags = BlogPost::find($blogPost->id)->tags()->get(); // return all tags associated with the current blogPost ** only retreiving the name field

        // return $blogPost; returns the fetched posts this name has to be the same as 'wildcard' variable used in the routes call 
        return view('blog.show')->with('post', $post)->with( 'currentTags', $currentTags);  //using the view method to go into the blog folder and show.blade.php file and retrieve the view with the data for the current post as $blogPost 
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogPost $blogPost, Tag $tags)
    {

        
        

        $allTags = Tag::all(); // return all tags from the database 
        
        $blogpost = BlogPost::find($blogPost->id); // find the current BlogPost

        $postTags = $blogpost->tags->pluck('id')->toArray(); // for this BlogPost ($blogpost) use the tags() function from the BlogPost MODEL to find the associated tag id's



        $tags = DB::table('tags')->get()->toArray(); // get the tags table info from the database with the get() method and save it as $tags variable
        
        $tagColors = array('primary','success','danger','dark', 'warning','info' );

        $newColors = array();

        foreach($allTags as $tag) {
            
            $chsnClr = $tagColors[array_rand($tagColors)];
            array_push($newColors, $chsnClr);
            
        }

        return view('blog.edit', [
            'post' => $blogPost,
            'allTags' => $allTags,
            'postTags' => $postTags,
            'newColors'=> $newColors,
            ]); //returns the edit view with the post ** also passed the user selected tags as $tags and All current tags as $allTags
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogPost $blogPost)
    {
        $blogPost->update([
            'title' => $request->title,
            'body' => $request->body
        ]);


        
        if ($request->get('newIpt')) {

            
            $addTag = $request->get('newIpt');
            

            foreach ($addTag as $tag) {            // this is looping through the tags in the input field the users added 
                $tagUppr = strtoupper($tag);
                $newTag = new Tag(['name' => $tagUppr]);
                $blogPost->tags()->save($newTag); 
            };

            $tagData = Tag::select('id', 'name') // this is retrieving the new tags that were saved into the database ABOVE line 66. It retrieves the tags with 'id' and 'name' attributes
            ->whereIn('name', $addTag)
            ->get();

            $tagDataId = $tagData->pluck('id')->toArray(); // this is retrieving the 'id' from the new tags we retrieved on line 73 

            

            $blogPost->tags()->sync($request->tags);
            $blogPost->tags()->syncWithoutDetaching($tagDataId);
            
            return redirect()->route('post-view',['blogPost' => $blogPost->id]);
        } else {
                // if no newTag input then just save the new BlogPost
                $blogPost->tags()->sync($request->tags);
                return redirect()->route('post-view',['blogPost' => $blogPost->id]);
            
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();

        return redirect()->route('cards-view');
    }

    


}