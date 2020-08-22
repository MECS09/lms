<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//for delete
use Illuminate\Support\Facades\Storage;

use App\Post;
//if you want to sql import use DB;
use DB;



class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return Post::all();
        
        
        //you can try this eloquent command for quering
        //$posts = Post::orderBy('title','desc')->get();
        //$posts = Post::where('title', 'Second Post')->get();
        //return Post::where('title', 'Second Post')->get();

        //$posts = Post::all();
        //db command below is same command above
        //$posts = DB::select('SELECT * FROM posts');
        
        
        //$posts = Post::orderBy('title','asc')->take(1)->get();
        //the command above will display 1 post only
        $posts = Post::orderBy('created_at','desc')->paginate(10);
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        if($request->hasFile('cover_image'))
        {
            // Get filename with the extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);


        }
        else
        {
            $fileNameToStore = 'noimage.jpg';
        }

        //create post using tinker commands
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request ->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post' , $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        //check for correct user
        if(auth()->user()->id !== $post->user_id)
        {
            return redirect('/posts')->with('error','Unauthorized page');
        }

        
        
        return view('posts.edit')->with('post' , $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        if($request->hasFile('cover_image'))
        {
            // Get filename with the extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);


        }

        //create post using tinker commands
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request ->input('body');
        if($request->hasFile('cover_image'))
        {
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        
        //
        $post=Post::find($id);
        
        //check for correct user
        if(auth()->user()->id !== $post->user_id)
        {
            return redirect('/posts')->with('error','Unauthorized page');
        }
        
        if($post->cover_image != 'noimage.jpg')
        {
            //Delete image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }


        $post->delete();
        return redirect('/posts')->with('success', 'Post Deleted');
    }
}
