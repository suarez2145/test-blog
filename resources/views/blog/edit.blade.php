@extends('layout')

@section('content')

    <div class="container edit-page-comp">
    <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm">Go back</a>

        <div class="row">
            <div class="col-12 pt-4">
                <div class="page-header">
                    <h1 class="display-4 header-txt">Edit Post</h1>
                </div>

                <div class="overflow-hidden">
                    <div class='page-subtitle-cont'>
                        <p class="subtitle-txt">Edit and submit this form to update a post</p>
                    </div>
                    <form action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class='tags-container row g-0' data-toggle="buttons">
                            @foreach($allTags as $k=> $t)
                            <label x-data="{ checked{{$t->id}}: false, }" class="btn btn-{{$newColors[$k]}} active m-2 border-0 col-3">
                                <input class='hide' x-on:click="checked{{$t->id}} = ! checked{{$t->id}}"  type="checkbox" name="tags[]" value="{{ $t->id }}" @if(in_array($t->id,$postTags)) :class='checked{{$t->id}} = true' checked @endif>
                                <span class="bi bi-check2" :class="checked{{$t->id}} ? '' : 'check-hide'"></span>
                                <span>{{$t->name}}</span>
                            </label>
                            @endforeach
                        </div>

                    <div class='' id='tagDiv' x-data="{ 
                        newTags: [],
                        addTag() { 

                            if ( this.newTags.length < 3 ) {
                                this.newTags.push({
                                newTag: this.tagCount++,
                                completed: false
                            });

                            }
                        },
                        deleteTag(index) {
                            this.newTags = this.newTags.filter((newTag, newTagIndex) => {
                            return index !== newTagIndex
                            })
                        },
                        }"> 

                        <div class='txt-button-container ms-3' id='txt-button-cont'>
                            <h6>Add Tag</h6>
                            <div class='txt-button d-flex flex-row' id='txt-button'>
                                <button class='btn btn-info text-white mb-3 mt-3 mx-2 rounded-0' type='button' @click="addTag()"> + </button>
                                
                                <template x-for='(newTag,index) in newTags':key='index'>
                                    <div class="d-flex items-center" >
                                        <input type="text"  x-bind:id="index" placeholder="Add New Tag" name="newIpt[]" class="form-control my-3 bdr-adj" required>
                                        <button id="btnCls1" name="btnCls" class="btn btn-outline-secondary  my-3 me-3 btn-bdr-adj" @click="deleteTag(index)" type="button">X</button>
                                    </div>
                                </template>
                                
                            </div>
                        </div>
                    </div>

                    <div class='post-txt-cont'>
                        <div class="row">
                            <div class="control-group col-12 post-title">
                                <label for="title" class='title-txt'>Post Title</label>
                                <input type="text" id="title" class="form-control" name="title"
                                    placeholder="Enter Post Title" value="{{ $post->title }}" required>
                            </div>
                            <div class="control-group col-12 mt-2 post-body">
                                <label for="body" class='body-txt'>Post Body</label>
                                <textarea id="body" class="form-control" name="body" placeholder="Enter Post Body" rows="5" required>{{ $post->body }}</textarea>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="control-group col-12 text-center">
                                <button id="btn-submit" class="btn btn-primary">
                                    Update Post
                                </button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection