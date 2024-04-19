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
        $per_page=20;
        //一覧の取得
        $list=TaskModel::where('user_id',Auth::id())
                        ->orderBy('priority','DESC')
                        ->orderBy('period')
                        ->orderBy('created_at')
                        ->paginate($per_page);
        //dd($list);
                       // ->get();//「user_idが"認可情報"と一致している」tasksテーブルの全件を取得。where('user_id',Auth::id())がなければtasksテーブルの全件取得
        /*$sql=TaskModel::where('user_id',Auth::id())
                        ->orderBy('priority','DESC')
                        ->orderBy('period')
                        ->orderBy('created_at')
                        ->tosql(); //tosqlはどんなSQLが流れているか確認できる。
        //echo "<pre>\n"; var_dump($sql,$list);*/
        return view('task.list',['list'=>$list]);


    }

        //テンプレートファイルが「ディレクトリ AAA 内のファイル BBB」の場合、通常は AAA/BBB と書くことが多いのですが、Laravelのテンプレートをview()関数に渡す場合は「AAA.BBB」と記述

    /**
     * 2nd ページを表示
     *
     * @return \Illuminate\View\View
     */
    public function register(TaskRegisterPostRequest $request)
    {
        // validate済みのデータの取得
        $datum = $request->validated();
        //
        //$user = Auth::user();
        //$id = Auth::id();
        //var_dump($datum, $user, $id); exit;

        // user_id の追加
        $datum['user_id'] = Auth::id();

        // テーブルへのINSERT
        try {
            $r = TaskModel::create($datum);
        } catch(\Throwable $e) {
            // XXX 本当はログに書く等の処理をする。今回は一端「出力する」だけ
            echo $e->getMessage();
            exit;
        }

        // タスク登録成功
        $request->session()->flash('front.task_register_success', true);

        //
        return redirect('/task/list');
    }

    public function detail($task_id)
    {


        return $this->singleTaskRender($task_id,'task.detail');

    }



    public function edit($task_id)
    {

        return $this->singleTaskRender($task_id,'task.edit');
    }



    protected function singleTaskRender($task_id,$template_name)
    {
        // task_idのレコードを取得する
        $task = TaskModel::find($task_id);

        if($task===null)
        {
            return redirect('/task/list');
        }

        //本人以外のタスクならアクセス拒否
        if($task->user_id !== Auth::id())
        {
            return redirect('task/list');
        }

        // テンプレートに「取得したレコード」の情報を渡す
        return view($template_name,['task'=>$task]);
    }

    public function editSave(TaskRegisterPostRequest $request,$task_id)
    {
        // formからの情報を取得する(validate済みのデータの取得)
        $datum=$request->validated();

        // task_idのレコードを取得する
        $task = TaskModel::find($task_id);
            if($task===null)
            {
                return redirect('/task/list');
            }
            if($task->user_id !== Auth::id())
            {
                return redirect('/task/list');
            }

        // レコードの内容をUPDATEする
        $task->name=$datum['name'];
        $task->period=$datum['period'];
        $task->detail=$datum['detail'];
        $task->priority=$datum['priority'];

        //レコードを更新
        $task->save();

        //タスク編集成功
        $request->session()->flash('front.task_edit_success', true);

        // 詳細閲覧画面にリダイレクトする
        return redirect(route('detail',['task_id'=>$task->id]));
    }


}



