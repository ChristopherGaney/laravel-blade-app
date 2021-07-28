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
        $tarray = [];
        $tasks = DB::table('tasks')->where('user_id', $user_id)->get();
        $tsks = compact('tasks');
        foreach($tsks['tasks'] as $tsk => $t) {
            //array_push($tarray, $t->id);
            $urls = DB::table('urls')->where('task_id', $t->id)->get();
            array_push($tarray, $tsk);
            $tsks['tasks'][$tsk]->urls = $urls;
        }
        
        //$tasks = auth()->user()->tasks();
        
        var_dump($tsks);
        //var_dump(compact('tasks'));
        return view('dashboard', compact('tasks'));
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

        Log::info($task->id);
        
        Log::info('word');
        Log::info($request->url);
        

        return redirect('/dashboard'); 
    }

    public function edit(Task $task)
    {

        if (auth()->user()->id == $task->user_id)
        {            
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
