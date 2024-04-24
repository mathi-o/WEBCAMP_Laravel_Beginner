<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompletedTask as CompletedTaskModel;
use Illuminate\Support\Facades\Auth;

class CompletedTaskController extends Controller
{
    //
    public function list()
    {
        $per_page = 1;

        $list = CompletedTaskModel::paginate($per_page);

        return view('task.completed_list',['list'=>$list]);
    }


}
