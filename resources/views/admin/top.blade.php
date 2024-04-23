@extends('admin.layout')

@section('contets')
        <menu label="リンク">
            <a href="./user_list.html">ユーザー一覧</a><br>
            管理機能画面　1<br>
            管理機能画面　2<br>
            管理機能画面　3<br>
            管理機能画面　4<br>

        <a href="/admin/logout">ログアウトする</a><br>
        </menu>
        <h1>管理画面</h1>
        (アクセス傾向のグラフや警告などを表示することが多い)<br>
@endsection