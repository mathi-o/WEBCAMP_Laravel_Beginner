<?php

declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller{
    /**
     * トップページを表示する
     *
     * @return \Illuminate\view\view
     */
    public function index(){

        return view('admin.index');
    }
//ログイン処理
    public  function login(AdminLoginPostRequest $request){

        $datum=$request->validated();
        //var_dump($datum); exit;


        //認証
        if (Auth::guard('admin')->attempt($datum) === false) {
            return back()
                   ->withInput() // 入力値の保持
                   ->withErrors(['auth' => 'ログインIDかパスワードに誤りがあります。',]); // エラーメッセージ
        }


        $request->session()->regenerate();
        return redirect()->intended('/admin/top');
        //return redirect('/admin/top');
    }
    /**
     * 2nd ページを表示
     * @return \Illuminate\View\View
     */
    /**
     * ログアウト処理
     */
        public function logout(Request $request){
        Auth::guard('admin')->logout();
        $request->session()->regenerateToken();  // CSRFトークンの再生成
        $request->session()->regenerate();  // セッションIDの再生成

        return redirect(route('admin.index'));
    }





}



