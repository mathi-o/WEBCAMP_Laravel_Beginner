<?php

declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRegisterPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Task as TaskModel;

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
    public function register(TaskRegisterPostRequest $request){

        $datum=$request->validated();
        //$user=Auth::user();
        //$id=Auth::id();
        //var_dump($datum,$user,$id); exit;

        //userIDの追加
        $datum['user_id']=Auth::id();

        //テーブルへのインサート
    try{
        $r = TaskModel::create($datum);

        var_dump($r); exit;
    } catch(\Throwable $e){
        echo $e->getMessage();
        exit;
    }

    //タスク登録成功
    $request->session()->flash('front.task_register_success',true);

    return redirect('/task/list');

    }


}



