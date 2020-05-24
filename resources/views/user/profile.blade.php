@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="profile-user">
                    @if($user->image)
                        <img class="avatar rounded-circle" src="{{ route('user.avatar',['filename'=>$user->image]) }}" alt="avatar"> 
                    @endif
                    <div class="user-info">
                        <h1>{{ $user->nick }}</h1>
                        <h2>{{ $user->name.' '.$user->surname }}</h2>
                        <span class="nickname date">{{'Se unió: '. \FormatTime::LongTimeFilter($user->created_at) }}</span> 
                    </div>
                    <div class="clearfix"></div>
                    <hr>
            </div>
            
            <div class="clearfix"></div>
            
            @foreach($user->images as $image)
                @include('includes.image', ['image'=>$image])
            @endforeach

        </div>
    </div>
</div>
@endsection