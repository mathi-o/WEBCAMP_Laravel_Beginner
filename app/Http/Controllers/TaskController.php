<?php

declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRegisterPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Task as TaskModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CompletedTask as CompletedTaskModel;


class TaskController extends Controller{
    /**
     * トップページを表示する
     *
     * @return \Illuminate\view\view
     */
    public function list(){
        $per_page=20;
        //一覧の取得
        $list=$this->getListBuilder()
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

    public function delete($task_id,Request $request)
    {
        //task_idのレコード入手
        $task = TaskModel::find($task_id);
            if($task===null)
            {
                return redirect('/task/list');
            }
            if($task->user_id !== Auth::id())
            {
                return redirect('/task/list');
            }
        //タスクを削除する
        if ($task !== null)
            {
                $task->delete();
            }
        $request->session()->flash('front.task_delete_success',true);
        //一覧に遷移する
        return redirect('/task/list');

    }

    public function complete($task_id,Request $request)
    {
        try{

            DB::beginTransaction();

        //タスクIDのレコード取得
        $task = TaskModel::find($task_id);
            if($task===null)
            {
                throw new \Exception('');
            }
           // var_dump($task->toArray()); exit;
        //tasks側を削除する
        $task->delete();
        //conpleted_tasks側にインサートする
        $dask_datum = $task->toArray(); //toArray() メソッドは、「Modelインスタンスのデータを連想配列として取り出せる」メソッド
        unset($dask_datum['created_at']);
        unset($dask_datum['updated_at']);
        $r = CompletedTaskModel::create($dask_datum);
        if($r === null){
            //insertに失敗したのでトランザクション中止
            throw new \Exception('');
        }
        //echo "処理成功"; exit;


            DB::commit();
            $request->session()->flash('front.task_completed_success',true);//完了メッセージ出力

        } catch(\Throwable $e){
            //var_dump($e->getMessage()); exit; //デバック処理
            DB::rollBack();
            $request->session()->flash('front.task_completed_failure',true); //完了失敗メッセージ出力
        }
        //一覧に遷移する
        return redirect('task/list');
    }

    public function csvDownload()
    {
        $data_list=[

            'id'=>'タスクID',
            'name'=>'タスク名',
            'period'=>'期限',
            'priority'=>'重要度',
            'detail'=>'タスク詳細',
            'created_at'=>'タスク作成日',
            'updated_at'=>'タスク修正日',

            ];


    /* 「ダウンロードさせたいCSV」を作成する */
        // データを取得する
        $list = $this->getListBuilder()->get();

        // バッファリングを開始
        ob_start();

        // 「書き込み先を"出力"にした」ファイルハンドルを作成する
        $file = new \SplFileObject('php://output', 'w');
        //ヘッダを書き込む
        $file->fputcsv(array_values($data_list));
        // CSVをファイルに書き込む(出力する)
        foreach($list as $datum) {
            $awk =[]; //作業領域確保

            //$data_listに書いてある順番に書いてある要素のみを$awkに格納
            foreach($data_list as $k=>$v)
            {
                $awk[]=$datum->$k;
            }
            $file->fputcsv($awk);
        }

        // 現在のバッファの中身を取得し、出力バッファを削除する
        $csv_string = ob_get_clean();

        // 文字コードを変換する
        $csv_string_sjis = mb_convert_encoding($csv_string, 'SJIS', 'UTF-8');

        //ダウンロードファイル名の作成
        $download_filename='task.list' . date('Ymd') . '.csv';

        // CSVを出力する
        return response($csv_string_sjis)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="' . $download_filename . '"');
    }

    protected function getListBuilder()
    {
        return TaskModel::where('user_id', Auth::id())
                     ->orderBy('priority', 'DESC')
                     ->orderBy('period')
                     ->orderBy('created_at');
    }
}



