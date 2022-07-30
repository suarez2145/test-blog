
@extends('layout')
@section('content')
    <div class="container clr-pd">
        <a href="{{route('create-page')}}" class="btn btn-md brdr">Add Post</a>
    </div>
    <div class="container">
        <div class="row row-cols-2 row-cols-md-3 g-3">
        @forelse($posts as $post)
        <div class="col">
            <div class="card brdr h-100">
                <img src="/images/social-media-g419eb81f2_1280.png" class="card-img-top brdr" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ ucfirst($post->title) }} </h5>
                    <p class="card-text">{{Str::limit($post->body, 50)}}</p>
                    <a href="./cards/{{ $post->id }}" class="btn btn-primary"> Go to post </a>
                </div>
            </div>
        </div>
            @empty
                <p class="text-warning">No blog Posts available</p>
        @endforelse
        </div>
    </div>
@endsection
