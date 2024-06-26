@extends('layout')
{{--タイトル--}}
@section('title')('詳細画面')@endsection

{{--コンテンツ--}}
@section('contets')
        <h1>タスクの登録</h1>
        @if (session('front.task_register_success') == true)
                タスクを登録しました<br>
        @endif
        @if (session('front.task_delete_success') == true)
            タスクを削除しました<br>
        @endif
        @if (session('front.task_completed_success') == true)
            タスクを完了しました。<br>
        @endif
        @if (session('front.task_completed_failure') == true)
            タスク完了に失敗しました<br>
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
        <h1>タスク一覧</h1>
        <a href="/task/csv/download">CSVダウンロード</a><br>

        <a href="/completed_tasks/list">完了タスク一覧</a>


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

                <td><a href="{{route('detail',['task_id'=>$task->id])}}">詳細閲覧</a>
                <td><a href="{{ route('edit',['task_id'=>$task->id]) }}">編集</a>
                <td><form action="{{route('complete',['task_id'=>$task->id])}}" method="post">
                    @csrf
                    <button onclick='return confilm("このタスクを完了しますか？");' >完了</button>
                </form>
            </tr>
        @endforeach

        </table>
        {{--{{$list->links()}}--}}
        現在{{$list->currentpage()}}ページ目<br>
        @if($list->onFirstPage()===false)
            <a href="/task/list">最初のページ</a>
        @else
            最初のページ
        @endif/
        @if($list->previousPageUrl()!==null)
            <a href="{{$list->previouspageurl()}}">前に戻る</a>
        @else
            前に戻る
        @endif/
        @if($list->nextPageUrl()!==null)
            <a href="{{$list->nextpageurl()}}">次に進む</a>
        @else
            次に進む
        @endif
        <br>
        <hr>
        <menu>
            <a href="/logout">ログアウト</a><br>
        </menu>
@endsection