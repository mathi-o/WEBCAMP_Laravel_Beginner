@extends('admin.layout')

@section('contets')

        <h1>ユーザー一覧</h1>
        <table border="1">
            <tr>
                <th>ユーザーID
                <th>ユーザ名
                <th>タスク件数
        @foreach ($users as $user)
            <tr>
                <td>{{$user->id}}
                <td>{{$user->name}}
                <td>{{$user->task_num}}
        @endforeach
            <tr>
                <td>1
                <td>WEB太郎
                <td>10
            <tr>
                <td>2
                <td>DMM 次郎
                <td>42
            <tr>
                <td>3
                <td>CAMP三郎
                <td>5
        </table>
@endsection