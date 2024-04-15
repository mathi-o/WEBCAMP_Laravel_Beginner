<?php

declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class WelcomeController extends Controller{
    /**
     * トップページを表示する
     *
     * @return \Illuminate\view\view
     */
    public function index(){

        return view('welcome');
    }
    /**
     * 2nd ページを表示
     *
     * @return \Illuminate\View\View
     */
    public function second(){
        return view('welcome_second');

    }
}



