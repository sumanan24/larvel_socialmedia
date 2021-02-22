<?php

namespace App\Http\Controllers;

use App\like;
use Illuminate\Support\Facades\Auth;
use App\post;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Http\Request;

class postcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts = Post::join('users','posts.user','=','users.id')
        ->select('posts.user', 'users.name', 'posts.post','posts.updated_at','posts.id')
        ->orderBy('updated_at','desc')
        ->groupBy('posts.id')
        ->get();
        
        $id=Auth::user()->id ;
        $likes = like::where('user', '=', $id)->get();
        
       
        $users = DB::table('likes')
        ->select('post', DB::raw('count(*) as total'))
        ->groupBy('post')
        ->get();
                
        return view('home',['posts' => $posts,'likes' => $likes],['like' => $users]);
    }
    
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = request()->validate([
            'post' => ['required','max:255'],
            'user' => 'required'
        ]);

        post::create($validatedData);
        return redirect()->back()->with('message', "Post create success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = post::where('id',$id); 
        like::where('post', $id)->delete();   
        $posts->delete();
        return redirect()->back()->with('message1', "post delete success");
    }
}
