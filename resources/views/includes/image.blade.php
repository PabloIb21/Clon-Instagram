<div class="card pub-image">
    <div class="card-header">
        @if($image->user->image)
            <img class="avatar rounded-circle" src="{{ route('user.avatar',['filename'=>$image->user->image]) }}" alt="avatar"> 
        @endif
        <div class="data-user">
            <a href="{{ route('profile',['id'=>$image->user->id]) }}">
                {{ $image->user->name.' '.$image->user->surname }}
                <span class="nickname">{{ ' | @'.$image->user->nick }}</span>
            </a>
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
        <div class="comments">
            <a href="{{ route('image.detail',['id'=>$image->id]) }}" class="btn btn-warning btn-comments btn-sm">Comentarios ({{ count($image->comments) }})</a>
        </div>
    </div>
</div>