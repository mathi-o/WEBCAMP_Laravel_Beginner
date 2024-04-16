<?php

declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;

class AuthController extends Controller{
    /**
     * トップページを表示する
     *
     * @return \Illuminate\view\view
     */
    public function index(){

        return view('index');
    }

    public  function login(LoginPostRequest $request){

        $datum=$request->validated();

        var_dump($datum); exit;


    }
    /**
     * 2nd ページを表示
     *
     * @return \Illuminate\View\View
     */



}



