<?php

declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller{
    /**
     * トップページを表示する
     *
     * @return \Illuminate\view\view
     */
    public function index(){

        return view('index');
    }
//ログイン処理
    public  function login(LoginPostRequest $request){

        $datum=$request->validated();
        //var_dump($datum); exit;

        //認証
        if (Auth::attempt($datum) === false) {
            return back()
                   ->withInput() // 入力値の保持
                   ->withErrors(['auth' => 'emailかパスワードに誤りがあります。',]); // エラーメッセージ
        }


        $request->session()->regenerate();
        return redirect()->intended('/task/list');
    }
    /**
     * 2nd ページを表示
     * @return \Illuminate\View\View
     */
    /**
     * ログアウト処理
     */
        public function logout(Request $request){
        Auth::logout();
        $request->session()->regenerateToken();  // CSRFトークンの再生成
        $request->session()->regenerate();  // セッションIDの再生成

        return redirect(route('front.index'));
    }





}



