<?php

namespace App\Http\Controllers;
use App\Post;
use App\User;
use App\Slug;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PostFormRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //

	  public function __construct(){

 			$this->middleware('auth')->except(['index','show','searchbypostin','searchforpostresult','searchbyuserin','searchforuserresult','searchbypostcontentin','searchforpostcontentresult']);
	  }

	  public function index()
	  {
		    //fetch 5 posts from database which are active and latest
		    $posts = Post::where('active',1)->orderBy('created_at','desc')->paginate(5);
		    //page heading
		    $title = 'Latest Posts';
		    //return home.blade.php template from resources/views folder
		    return view('home')->withPosts($posts)->withTitle($title);
	  }
	  public function create(Request $request)
	  {
	        // if user can post i.e. user is admin or author
		    if($request->user()->can_post())
		    {
		      return view('posts.create');
		    }    
		    else 
		    {
		      return redirect('/home')->withMessage('You do not have sufficient permissions for writing post');
		    }
	  }
	  public function store(PostFormRequest $request)
	  {
		    $slug=Slug::find(1);
		    $slugnum=$slug->slugcount;
		    $forslug=(string)$slugnum;
		    $slug->slugcount=$slugnum+1;
		    $slug->save();
		    $post = new Post();
		    $post->title = $request->get('title');
		    $post->body = $request->get('body');
		    $post->slug = $forslug;
		    $post->author_id = $request->user()->id;
		    $post->author_name=$request->user()->name;
		    if($request->has('save'))
		    {
		      $post->active = 0;
		      $message = 'Post saved successfully';            
		    }            
		    else 
		    {
		      $post->active = 1;
		      $message = 'Post published successfully';
		    }
		    $post->save();
		    //return redirect('edit/'.$post->slug)->withMessage($message);
		    return redirect('/home') ->withMessage($message);
	  }
	  public function show($slug)
	  {
		    $post = Post::where('slug',$slug)->first();
		    if(!$post)
		    {
		       return redirect('/home')->withMessage('requested page not found');
		    }
		    $comments = $post->comments;
		    return view('posts.show')->withPost($post)->withComments($comments);
	  }
	  public function edit(Request $request,$slug)
	  {
		    $post = Post::where('slug',$slug)->first();
		    if($post && ($request->user()->id == $post->author_id || $request->user()->is_admin()))
		      return view('posts.edit')->with('post',$post);
		    return redirect('/home')->withMessage('you do not have sufficient permissions');
	  }
	  public function update(Request $request)
	  {
	    
		    $post_id = $request->input('post_id');
		    $post = Post::find($post_id);
		    if($post && ($post->author_id == $request->user()->id || $request->user()->is_admin()))
		    {
			      $title = $request->input('title');
			      $slug = $post->slug;
			      $post->title = $request->input('title');
			      $post->body = $request->input('body');
			      if($request->has('save'))
			      {
				        $post->active = 0;
				        $message = 'Post saved successfully';
				        //$landing = 'edit/'.$post->slug;
			      }            
			      else {
				        $post->active = 1;
				        $message = 'Post updated successfully';
				        //$landing = $post->slug;
			      }
			      $post->save();
			      return redirect('/home')->withMessage($message);
		    }
		    else
		    {
		      	  return redirect('/home')->withMessage('you do not have sufficient permissions');
		    }
	  }
	  public function destroy(Request $request, $id)
	  {
		    //
		    $post = Post::find($id);
		    if($post && ($post->author_id == $request->user()->id || $request->user()->is_admin()))
		    {
			      $post->delete();
			      $data['message'] = 'Post deleted Successfully';
			      return redirect('/home')->with($data);
		    }
		    else 
		    {
			      return redirect('/home')->withMessage('you do not have sufficient permissions');
		    }
	    
	  }
	  public function searchbypostin()
	  {
	        return view('searchbypostin');
	  }
	  public function searchbyuserin(){
	        return view('searchbyuserin');
	  }
	  public function searchbypostcontentin(){
	        return view('searchbypostcontentin');
	  }
	  public function searchforpostresult(Request $request){
	        $searchstring=$request->input('searchpostname');
	        $previoussearch=$searchstring;
	        $searchstring='%'.$searchstring.'%';
	        $posts = Post::where('active',1)->where('title','LIKE',$searchstring)->orderBy('created_at','desc')->paginate(5);
	  		$title = 'Posts with Title '.$previoussearch;
	        return view('home')->withPosts($posts)->withTitle($title);
	  }
	  public function searchforuserresult(Request $request){
		      $searchstring=$request->input('searchusername');
		      $previoussearch=$searchstring;
		      $searchstring='%'.$searchstring.'%';
		      // $posts=Post::whereHas('author',function($query){
		      // $query->where('name','LIKE','ami ami');})->orderBy('created_at','desc')->paginate(5);
		      // $posts=DB::table('posts')
		      // 		 ->join('users','posts.author_id','=','users.id')
		      // 		 ->select('posts.*')
		      // 		 ->where('posts.active',1)->where('users.name','LIKE',$searchstring)->orderBy('posts.created_at','desc')->paginate(5);
		      $posts=Post::where('active',1)->where('author_name','LIKE',$searchstring)->orderBy('created_at','desc')->paginate(5);
		      $title = 'Posts By Searched User ';
		      return view('home')->withPosts($posts)->withTitle($title);
	  }
	  public function searchforpostcontentresult(Request $request){
	        $searchstring=$request->input('searchpostname');
	        $previoussearch=$searchstring;
	        $searchstring='%'.$searchstring.'%';
	        $posts = Post::where('active',1)->where('body','LIKE',$searchstring)->orderBy('created_at','desc')->paginate(5);
	  		$title = 'Posts with keyword '.$previoussearch;
	        return view('home')->withPosts($posts)->withTitle($title);
	  }
}
