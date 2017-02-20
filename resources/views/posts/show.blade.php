@extends('layouts.app')
@section('title')
  @if($post)
    {{ $post->title }}
    @if(!Auth::guest() && ($post->author_id == Auth::user()->id || Auth::user()->is_admin()))
      <button class="btn" style="float: right"><a href="{{ url('edit/'.$post->slug)}}">Edit Post</a></button>
    @endif
  @else
    Page does not exist
  @endif
@endsection
@section('title-meta')
<p>{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }} By {{ $post->author->name }} </p>
@endsection
@section('content')
@if($post)
  <div>
    {!! $post->body !!}
  </div>    
  <div>
    <h3>Leave a comment</h3>
  </div>
  @if(Auth::guest())
    <p>Login to Comment</p>
  @else
    <div class="panel-body">
     <form method="post" action="/{{ $post->id }}/comment/add">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="on_post" value="{{ $post->id }}">
        <input type="hidden" name="slug" value="{{ $post->slug }}">
        <div class="form-group">
          <textarea required="required" placeholder="Enter comment here" name = "body" class="form-control"></textarea>
        </div>
        <input type="submit" name='post_comment' class="btn btn-success" value = "Post"/>
      </form>
    </div>
  @endif
  <div>
    @if($comments)
    <div>
      <h3>Comments</h3>
    </div>
    <hr>
    <ul style="list-style: none; padding: 0">
      @foreach($comments as $comment)
        <li class="panel-body">
          <div class="list-group">
            <div class="list-group-item">
             
              @if(!Auth::guest() && ($comment->author->id == Auth::user()->id || Auth::user()->is_admin() ))
          
                <button class="btn" style="float: right"><a href="{{ url('commentedit/'.$comment->slug)}}">Edit</a></button>
          
              @endif
              
              
              

              <p>{{ $comment->created_at->format('M d,Y \a\t h:i a') }} By {{ $comment->author->name }}</p>
            </div>
            <div class="list-group-item">
              <p>{{ $comment->body }}</p>
            </div>
          </div>
        </li>
      @endforeach
    </ul>
    @endif
  </div>
@else
404 error
@endif
@endsection