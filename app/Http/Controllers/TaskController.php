<?php

declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class TaskController extends Controller{
    /**
     * トップページを表示する
     *
     * @return \Illuminate\view\view
     */
    public function list(){

        return view('task.list');
        //テンプレートファイルが「ディレクトリ AAA 内のファイル BBB」の場合、通常は AAA/BBB と書くことが多いのですが、Laravelのテンプレートをview()関数に渡す場合は「AAA.BBB」と記述
    }
    /**
     * 2nd ページを表示
     *
     * @return \Illuminate\View\View
     */



}



