@extends('layout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12 pt-2">
                
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm">Go back</a>
                <div class="border rounded mt-5 pl-4 pr-4 pt-4 pb-4">
                    <h1 class="display-4">Edit Post</h1>
                    <p>Edit and submit this form to update a post</p>

                    <hr>

                    <form action="" method="POST">
                        @csrf
                        @method('PUT')

                        <div>
                        @foreach($allTags as $t)

                            <div class="badge">
                                <span class="badge bg-primary mx-1">
                                    <input type="checkbox" name="tags[]" value="{{ $t->id }}" @if(in_array($t->id,$postTags)) checked @endif> {{ $t->name }}
                                </span>
                            </div>
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

                        <div class='txt-button-container' id='txt-button-cont'>
                            <h6>Add Tag</h6>
                            <div class='txt-button d-flex flex-row' id='txt-button'>
                                <!-- <input type="text" id="new-tag" style="text-transform:uppercase" class="form-control w-25" name="newTag" placeholder="Add New Tag"> -->
                                <button class=' btn btn-info text-white mb-3 mt-3 mx-2' type='button' @click="addTag()"> + </button>
                                
                                <template x-for='(newTag,index) in newTags':key='index'>
                                    <div class="d-flex items-center" >
                                        <input type="text"  x-bind:id="index" placeholder="Add New Tag" name="newIpt[]" class="form-control my-3" required>
                                        <button id="btnCls1" name="btnCls" class="btn btn-outline-secondary my-3 me-3" @click="deleteTag(index)" type="button">X</button>
                                    </div>
                                </template>
                                
                            </div>
                        </div>
                    </div>


                        <div class="row">
                            <div class="control-group col-12">
                                <label for="title">Post Title</label>
                                <input type="text" id="title" class="form-control" name="title"
                                    placeholder="Enter Post Title" value="{{ $post->title }}" required>
                            </div>
                            <div class="control-group col-12 mt-2">
                                <label for="body">Post Body</label>
                                <textarea id="body" class="form-control" name="body" placeholder="Enter Post Body"
                                        rows="5" required>{{ $post->body }}</textarea>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="control-group col-12 text-center">
                                <button id="btn-submit" class="btn btn-primary">
                                    Update Post
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection