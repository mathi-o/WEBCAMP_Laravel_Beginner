<?php

declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User as UserModel;

class UserController extends Controller{
    /**
     * トップページを表示する
     *
     * @return \Illuminate\view\view
     */
    public function list(){
        $group_by_column = ['users.id','users.name'];
        $list = UserModel::select($group_by_column)
                    ->selectRaw('count(tasks.id) AS task_num')
                    ->leftJoin('tasks','users.id','=','tasks.user_id')
                    ->groupBy($group_by_column) //GROUP BYは、「（指定した）同じ値のレコードを1レコードにまとめる」機能
                    ->orderBy('users.id')
                    ->get();
//echo "<pre>\n";
//var_dump($list->toArray()); exit;
        return view('admin.user.list',['users'=>$list]);
    }
}



