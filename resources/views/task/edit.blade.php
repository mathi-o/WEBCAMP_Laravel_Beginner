@extends('layout')
{{--タイトル--}}
@section('title')('編集画面')@endsection

{{--コンテンツ--}}
@section('contets')
        <h1>タスクの登録(未実装)</h1>

        @if($errors->any())
                <div>
                    @foreach($errors->all() as $error)
                        {{$error}}<br>
                    @endforeach
                </div>
            @endif

        <form action="{{ route('edit_save',['task_id'=>$task->id]) }}" method="post">
            @csrf
            @method("PUT")
            タスク名:<input name="name" value="{{old('name') ?? $task->name}}"><br>
            期限:<input name="period" type="date" value="{{ old('period') ?? $task->period}}"><br>
            タスク詳細:<textarea name="detail" value="{{ old('detail') ?? $task->detail}}"></textarea><br>
            重要度:<label><input name="priority" type="radio"  value="1" @if((old('priority') ?? $task->priority)==1) checked @endif>低い</label>/
                <label><input name="priority" type="radio"  value="2" @if((old('priority') ?? $task->priority)==2) checked @endif>普通 </label>/
                <label><input name="priority" type="radio" value="3" @if((old('priority') ?? $task->priority)==3) checked @endif>高い </label><br>
                <button>タスクを編集する</button>
        </form>

        <hr>
        <menu label="リンク">
            <a href="/task/list">タスク一覧</a>
            <a href="/logout">ログアウト</a><br>
        </menu>
@endsection