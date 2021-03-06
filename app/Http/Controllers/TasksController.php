<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\Url;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TasksController extends Controller
{
    public function index()
    {

         $user_id = auth()->user()->id;
         $tasks = DB::table('tasks')->where('user_id', $user_id)->get();
         $task_arr = compact('tasks');
         foreach($task_arr['tasks'] as $tsk => $t) {
             $urls = DB::table('urls')->where('task_id', $t->id)->get();
             $task_arr['tasks'][$tsk]->urls = $urls;
         }
        //$tasks = auth()->user()->tasks();
        return view('dashboard', $task_arr); //compact('tasks')
    }
    public function add()
    {
        return view('add');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'description' => 'required'
        ]);
        $task = new Task();
        $task->description = $request->description;
        $task->user_id = auth()->user()->id;
        $task->save();

        $url = new Url();
        $url->url = $request->url;
        $url->task_id = $task->id;//auth()->user()->task()->id;
        $url->save();

        return redirect('/dashboard'); 
    }

    public function edit(Task $task)
    {

        if (auth()->user()->id == $task->user_id)
        { 
                print_r($task);           
                return view('edit', compact('task'));
        }           
        else {
             return redirect('/dashboard');
         }              
    }

    public function update(Request $request, Task $task)
    {
        if(isset($_POST['delete'])) {
            $task->delete();
            return redirect('/dashboard');
        }
        else
        {
            $this->validate($request, [
                'description' => 'required'
            ]);
            $task->description = $request->description;
            $task->save();
            return redirect('/dashboard'); 
        }       
    }
}
