@extends('layouts.app')
<style>
.divider{
    width:890px;
    height:auto;
    display:inline-block;
}
</style>
@section('title')
{{$title}}
@endsection
@section('content')
@if ( !$posts->count() )
There is no post till now.
@else
<div class="">
  @foreach( $posts as $post )
  <div class="list-group">
    <div class="list-group-item">
      <h3><a href="{{ url('/'.$post->slug) }}">{{ $post->title }}</a>
        @if(!Auth::guest() && ($post->author_id == Auth::user()->id || Auth::user()->is_admin() ))
          @if($post->active == '1')
          <button class="btn" style="float: right"><a href="{{ url('delete/'.$post->id)}}">Delete</a></button>
          <button class="btn" style="float: right"><a href="{{ url('edit/'.$post->slug)}}">Edit</a></button>
          @endif
        @endif
      </h3>
      @if($post->updated_at->gt($post->created_at))
      <p>Created {{ $post->created_at->format('M d,Y \a\t h:i a') }} (GMT), Last Updated {{ $post->updated_at->format('M d,Y \a\t h:i a') }} (GMT) By {{ $post->author->name }} </p>
      @else <p>Created {{ $post->created_at->format('M d,Y \a\t h:i a') }} (GMT) By {{ $post->author->name }} </p>
      @endif
    </div>
    <div class="list-group-item">
      <article>
        {!! str_limit($post->body, $limit = 1500, $end = '....... <a href='.url("/".$post->slug).'>Read More</a>') !!}
      </article>
    </div>
  </div>
  @endforeach
  {!! $posts->render() !!}
</div>
@endif
@endsection