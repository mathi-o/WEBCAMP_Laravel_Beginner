
@extends('layout')

{{--メインコンテンツ--}}
@section ('contets')
    @if($errors->any())
        <div>
            @foreach($errors->all() as $error){
                {$error}
            }<br>
            @endforeach
        </div>
    @endif
        <h1>ログイン</h1>
        <form action="/login" method="post">
            @csrf
            email：<input name="email" value="{{old('email')}}"><br>
            パスワード：<input  name="password" type="password"><br>
            <button>ログインする</button>
        </form>
@endsection