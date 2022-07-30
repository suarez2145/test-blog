@extends('layout')
@section('content')

    <div class="container mt-5 mb-5">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <a href="{{route('cards-view')}}" class="btn btn-outline-primary btn-sm">Go back</a>
        <div class="d-flex justify-content-center row">
            <div class="d-flex flex-column col-md-8">
                <div class="d-flex flex-row align-items-center text-left comment-top p-2 bg-white border-bottom px-4">
                    <div class="profile-image"><img class="rounded-circle" src="https://i.imgur.com/t9toMAQ.jpg" width="70"></div>
                    <div class="d-flex flex-column ms-3">
                        <div class="d-flex flex-row post-title">
                            <h5>{{$post->body}}</h5><span class="ms-2 me-3"> ({{ $post->user->name }})</span>
                            @can('verify', $post)
                                <a href="/blog/{{ $post->id }}/edit" class="btn btn-primary btn-sm me-2">Edit Post</a> 
                                
                                    <form id="delete-frm" class="" action="" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger btn-sm">Delete Post</button>
                                    </form>
                                
                            @else
                                
                            @endcan
                        </div>
                        <div class="d-flex flex-row align-items-center align-content-center post-title">
                            <span class="me-2 comments">
                                    {{ ($post->created_at)->diffForHumans()}} 
                            </span>
                            <span class="me-2 dot"></span>
                            
                            @foreach($currentTags as $t)
                            <span class="badge bg-primary mx-1">
                                {{ $t->name }}
                            </span>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
                <div class="coment-bottom bg-white p-2 px-4">
                    <div class="d-flex flex-row add-comment-section mt-4 mb-4">
                    <form action="{{ route('create-comment', ['id'=> $post->id])}}" method="POST">
                        @csrf
                        
                            <div class="input-group input-group-sm me-5">
                                <img class="img-fluid img-responsive rounded-circle me-2" src="https://i.imgur.com/qdiP4DB.jpg" width="38">
                                <!-- <textarea id="comment_txt" class="form-control" name="comment_txt" placeholder="Enter Post Body" rows="" required></textarea> -->
                                <input id="comment_txt" type="text" class="form-control me-3" name="comment_txt" placeholder="Add comment" required><button id="btn-submit" class="btn btn-primary">Add Comment </button>
                            </div>
                    </form>
                    </div>   

                    <div class="commented-section mt-2"> 
                        @forelse($post->blogComments as $comment)
                            <div class="d-flex flex-row align-items-center commented-user">
                                <h5 class="me-2">{{ $comment->user->name }}</h5>
                                <span class="dot mb-1"></span>
                                <span class="mb-1 ms-2">
                                    {{ ($comment->created_at)->diffForHumans()}}
                                </span>
                            </div>
                            <div class="comment-text-sm"><span>{{ $comment['comment_txt'] }}</span></div>
                            @empty
                            <p class="text-warning">No Comments Available</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>   
@endsection