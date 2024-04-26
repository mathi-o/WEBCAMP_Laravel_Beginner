
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
        <h1>ログイン</h1>
         @if(session('front.task_register_success') == true)
            ユーザを登録しました！
        @endif
        @if(session('front.task_register_failure') == true)
            ユーザ登録失敗しました。
        @endif
        <form action="/login" method="post">
            @csrf
            email：<input name="email" value="{{old('email')}}"><br>
            パスワード：<input  name="password" type="password"><br>
            <button>ログインする</button>
        </form>


        <a href="/user/register">会員登録</a>

@endsection