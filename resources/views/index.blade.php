
@extends('layout')

{{--メインコンテンツ--}}
@section ('contets')
        @if(session('front.task_register_success') == true)
            会員登録完了
        @endif
        @if(session('front.task_register_failure') == true)
            会員登録失敗
        @endif
        @if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
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

        <menu>
            <a href="/user/register">会員登録</a>
        </menu>
@endsection