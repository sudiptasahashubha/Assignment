<?php

namespace App\Http\Controllers;
use App\Post;
use App\Comment;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CommentSlug;

class CommentController extends Controller
{
    //
      public function __construct(){

 			$this->middleware('auth');
	  }
	  public function store(Request $request,$postno)
	  {
	    	$comslug=CommentSlug::find(1);
		    $slugnum=$comslug->slugcount;
		    $forslug=(string)$slugnum;
		    $comslug->slugcount=$slugnum+1;
		    $comslug->save();
		    $input['from_user'] = $request->user()->id;
		    $input['on_post'] = $request->input('on_post');
		    $input['body'] = $request->input('body');
		    $input['slug']=$forslug;
		    $slug = $request->input('slug');
		    Comment::create( $input );
		    return redirect($slug)->with('message', 'Comment published successfully!');     
	  }

	  public function edit(Request $request,$slug)
	  {
		    $comment = Comment::where('slug',$slug)->first();
		    if($comment && ($request->user()->id == $comment->author->id || $request->user()->is_admin()))
		      return view('editinplace')->with('comment',$comment);
		    return redirect('/home')->withMessage('you do not have sufficient permissions');
	  }

	  public function update(Request $request)
	  {
	    //
		    $comment_id = $request->input('comment_id');
		    $comment = Comment::find($comment_id);
		    $anoslug=$comment->post->slug;
		    if($comment && ($comment->author->id == $request->user()->id || $request->user()->is_admin()))
		    {
		      
			      $slug = $comment->slug;
			      $comment->slug = $slug;
			      $comment->body = $request->input('body');
			      $message='Comment updated succesfully!';
			      $comment->save();
			      return redirect($anoslug)->with('message', $message); 
		    }
		    else
		    {
		      	  return redirect($anoslug)->with('message','you do not have sufficient permissions');
		    }
	  }

	  public function destroy(Request $request, $id)
	  {
	    //
		    $comment = Comment::find($id);
		    $anoslug=$comment->post->slug;
		    if($comment && ($comment->author->id == $request->user()->id || $request->user()->is_admin()))
		    {
			      $comment->delete();
			      return redirect($anoslug)->with('message', 'Comment deleted successfully!'); 
		    }
		    else{
		      	  return redirect($anoslug)->with('message', 'you do not have sufficient permission');
		    } 
	  }
}
