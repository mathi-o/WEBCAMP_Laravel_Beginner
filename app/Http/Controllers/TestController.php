<?php

declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TestPostRequest;

class TestController extends Controller{
    /**
     * トップページを表示する
     *
     * @return \Illuminate\view\view
     */
    public function index(){

        return view('test.index');
    }

    public function input(TestPostRequest $request){

        //validate済

        //データの取得
        $validatedData=$request->validated();
            var_dump($validatedData); exit;


        return view('test.input',['$datum'=>$validatedData]);
    }
    /**
     * 2nd ページを表示
     *
     * @return \Illuminate\View\View
     */



}



