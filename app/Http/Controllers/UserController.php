<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRegisterPost;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index()
    {
        return view('user.register');
    }

    public function register(UserRegisterPost $request)
    {
        //try{
            //DB::beginTransaction();
            $datum = $request->validated();
            $datum['password'] = Hash::make($datum['password']);
//ddd($datum);
            /*if($datum === null)
            {
                throw new \Exception('');
            }*/
            $r = UserModel::create($datum);
//ddd($r);
           /* if($r === null)
            {
                throw new \Exception('');
            }
            //DB::commit;*/
            $request -> session()->flash('front.task_register_success',true);

        //}catch(\Throwable $e)
        /*{
            DB::rollBack();
            $request -> session()->flash('front.task_register_failure',true);
        }*/
        return redirect('/');
    }
}
