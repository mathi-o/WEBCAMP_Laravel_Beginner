@extends('layout')
{{--タイトル--}}
@section('title')('詳細画面')@endsection

{{--コンテンツ--}}
@section('contets')
        <h1>タスクの登録(未実装)</h1>
        @if (session('front.task_register_success') == true)
                タスクを登録しました<br>
        @endif

        @if($errors->any())
                <div>
                    @foreach($errors->all() as $error)
                        {{$error}}<br>
                    @endforeach
                </div>
            @endif

        <form action="/task/register" method="post">
            @csrf
            タスク名:<input name="name" value="{{old('name')}}"><br>
            期限:<input name="period" type="date" value="{{old('period')}}"><br>
            タスク詳細:<textarea name="detail" value="{{old('detail')}}"></textarea><br>
            重要度:<label><input name="priority" type="radio"  value="1" @if(old('priority')==1) checked @endif>低い</label>/
                <label><input name="priority" type="radio"  value="2" @if(old('priority',2)==2) checked @endif>普通 </label>/
                <label><input name="priority" type="radio" value="3" @if(old('priority')==3) checked @endif>高い </label><br>
                <button>タスクを登録する</button>
        </form>
        <h1>タスク一覧(未実装)</h1>
        <a href="./top.html">CSVダウンロード</a><br>
        <table border="1">
            <tr>
                <th>タスク名
                <th>期限
                <th>重要度
            </tr>
        @foreach($list as $task)
            <tr>
                <td>{{$task->name}}
                <td>{{$task->period}}
                <td>{{$task->getPriorityString()}}
                <td><a href="./detail.html">詳細閲覧</a>
                <td><a href="./edit.html">編集</a>
                <td><form action="./top.html"><button>完了</button></form>
            </tr>
        @endforeach

        </table>
        現在1ページ目<br>
        <a href="./top.html">最初のページ(未実装)</a>/
        <a href="./top.html">前に戻る(未実装)</a>/
        <a href="./top.html">次に進む(未実装)</a>
        <br>
        <hr>
        <menu>
            <a href="/logout">ログアウト</a><br>
        </menu>
@endsection