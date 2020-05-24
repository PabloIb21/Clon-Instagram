@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
        @include('includes.message')
            <div class="card pub-image pub-image-detail">
                <div class="card-header">
                    @if($image->user->image)
                        <img class="avatar rounded-circle" src="{{ route('user.avatar',['filename'=>$image->user->image]) }}" alt="avatar"> 
                    @endif
                    <div class="data-user">
                        {{ $image->user->name.' '.$image->user->surname }}
                        <span class="nickname">{{ ' | @'.$image->user->nick }}</span>
                    </div> 
                </div>

                <div class="card-body">
                    <div class="image-container">
                        <img src="{{ route('image.file', ['filename' => $image->image_path]) }}" alt="imagen">
                    </div>
                    
                    <div class="description">
                        <span class="nickname">{{'@'. $image->user->nick }}</span>
                        <span class="nickname date">{{' | '. \FormatTime::LongTimeFilter($image->created_at) }}</span> 
                        <p class="description">{{ $image->description }}</p>
                    </div>
                    <div class="likes">
                        <!-- Comprobar si el usuario le dio like a la imagen -->
                        <?php $user_like = false; ?>
                        @foreach($image->likes as $like)
                            @if($like->user_id == Auth::user()->id)
                                <?php $user_like = true; ?>
                            @endif
                        @endforeach

                        @if($user_like)
                            <i class="fas fa-heart btn-dislike" data-id="{{ $image->id }}"></i>
                        @else
                            <i class="fas fa-heart btn-like" data-id="{{ $image->id }}"></i>
                        @endif

                        {{ count($image->likes) }}
                    </div>

                    @if(Auth::user() && Auth::user()->id == $image->user->id)
                        <div class="actions">
                            <a href="{{ route('image.edit',['id'=>$image->id]) }}" class="btn btn-warning btn-sm">Actualizar</a>
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal">
                            Eliminar
                            </button>

                            <!-- The Modal -->
                            <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">¿Estás seguro?</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    Si eliminas está imagen nunca podrás recuperarla, ¿estás seguro?
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                    <a href="{{ route('image.delete',['id' => $image->id]) }}" class="btn btn-danger">Borrar definitivamente</a>
                                </div>

                                </div>
                            </div>
                            </div>
                        </div>
                    @endif

                    <div class="clearfix"></div>
                    <div class="comments">
                        <h2>Comentarios ({{count($image->comments)}})</h2> 
                        <hr>
                        <form action="{{ route('comment.save') }}" method="post">
                            @csrf
                            <input type="hidden" name="image_id" value="{{ $image->id }}">
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" required></textarea>
                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="submit" class="btn btn-success my-3" value="Enviar">
                        </form>
                        <hr>
                        @foreach($image->comments as $comment)
                            <div class="comment">
                                <div class="description">
                                    <span class="nickname">{{'@'. $comment->user->nick }}</span>
                                    <span class="nickname date">{{' | '. \FormatTime::LongTimeFilter($comment->created_at) }}</span> 
                                    <p>{{ $comment->content }}</p>
                                    @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                        <a class="btn btn-sm btn-danger" href="{{ route('comment.delete',['id'=>$comment->id]) }}">Eliminar</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection