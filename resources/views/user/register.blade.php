
@extends('layout')

{{--メインコンテンツ--}}
@section ('contets')

        @if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
        @endif
        <h1>会員登録</h1>
        <form action="/user/register" method="post">
            @csrf
            name:<input name='name'><br>
            email：<input name="email"><br>
            パスワード：<input  name="password" type="password"><br>
            <button>会員登録する</button>
        </form>
@endsection