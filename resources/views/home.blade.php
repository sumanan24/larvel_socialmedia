@extends('layouts.app')
<style>
    .cmt {
        border-top: 1px solid rgba(0, 0, 0, 0.466);
        border-bottom: 1px solid rgba(0, 0, 0, 0.466);
        padding-top: 5px;
        padding-bottom: 5px;
    }

</style>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    @if (session()->has('message1'))
                        <div class="row">

                            <div class="col-12">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong> {{ session('message1') }}</strong>
                                    <meta http-equiv='refresh' content='0.2'>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card-header">{{ __('Create post') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="createpost">
                            @csrf
                            @if (session()->has('message'))
                                <div class="row">

                                    <div class="col-12">
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong> {{ session('message') }}</strong>
                                            <meta http-equiv='refresh' content='0.2'>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <textarea id="post" class="form-control @error('post') is-invalid @enderror" name="post"
                                        value="{{ old('post') }}" required autocomplete="post" autofocus>
                                                                                                                                    </textarea>
                                    @error('post')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col"></div>
                                <div class="col-auto">
                                    <p id="demo"></p>
                                    <input type="text" style="display:none" name="user" value="{{ Auth::user()->id }}">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create Post ') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <p style="display:none">
                    {{ $length = 0 }}
                    @foreach ($likes as $like)
                        {{ $like_post_ids[] = $like->post }}
                        {{ $length = count($like_post_ids) }}
                    @endforeach
                </p>
                
                @foreach ($posts as $post)
                    <br>

                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col text-primary">
                                    <h6>{{ $post->name }} posted at {{ $post->updated_at }}</h6>
                                </div>
                                <div class="col-auto">
                                    @if ($post->user == Auth::user()->id)
                                        <a href="edit{{ $post->id }}" class=" btn btn-sm bg-primary btn-sm"><img
                                                src="img/edit.png" alt="" style="width: 15px;"></a>
                                        <a href="delete{{ $post->id }}" class="btn btn-sm bg-danger text-light btn-sm">
                                            <img src="img/delete.png" alt="" style="width: 15px;"> </a>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="card-body">
                            {{ $post->post }}


                            <form action="like" method="get" class="form1">
                                <input type="text" style="display:none" name="post" value="{{ $post->id }}">
                                <input type="text" style="display:none" name="user" value="{{ Auth::user()->id }}"><br>
                                <p style="display:none">{{ $status = 'unliked' }}</p>
                                @for ($i = 0; $i < $length; $i++)
                                    @if ($post->id == $like_post_ids[$i]) <p
                                    style="display:none">{{ $status = 'liked' }}</p> @endif
                                @endfor

                                @if ($post->likepost == 1)
                                    <div style="color: rgb(29, 29, 209)">This post has{{ $post->likepost }}like.</div>
                                @endif
                                @if ($post->likepost > 1)
                                    <div style="color: rgb(29, 29, 209);"> This post have {{ $post->likepost }} likes.
                                    </div>
                                @endif
                                <div class="cmt">
                                    @if ($status == 'liked')
                                        <a href="unlike{{ $like->id }}" class="btn btn-primary">
                                            <img src="img/unlike.png" alt="" style="width: 15px;"> {{ __('Unlike') }}
                                        </a>
                                    @else
                                        <button type="submit" class="btn btn-primary">
                                            <img src="img/like.png" alt="" style="width: 15px;"> {{ __('Like') }}
                                        </button>
                                    @endif

                                    <a href="" class="btn btn-primary"> <img src="img/comment.png" alt=""
                                            style="width: 15px;">
                                        Comments</a>
                                </div>
                            </form>

                            <form method="POST" action="" class="form1">
                                <div class="form-group row mb-0">

                                    <div class="col-md-12">
                                        <input id="comment" type="text"
                                            class="form-control @error('comment') is-invalid @enderror" name="comment"
                                            value="{{ old('comment') }}" required autocomplete="comment" autofocus>

                                        @error('comment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row mb-0">
                                    <div class="col"></div>
                                    <br>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('submit your comment') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach



            </div>
        </div>
    </div>
@endsection
