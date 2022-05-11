<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(){
        return view('task');
    }

    public function getTask(){
        $tasks = Task::where('flag', 1)->get();

        $i = 0;
        $array = [];
        foreach($tasks as $t ){
            $array[$i] = array(
                'id' => $t->id,
                'title' => $t->title,
                'datetime' => $t->datetime,
                'memo' => $t->memo,
                'category' => $t->category,
            );
            $i++;
        }
        return $array;
    }

    public function insTask(Request $request){
        $data = $request->all();
        $data['date'] = $data['date'] . ' 00:00:00';

        $task = new Task;
        $task->title = $data['title'];
        $task->datetime = $data['date'];
        $task->memo = $data['memo'];
        $task->category = $data['category'];
        $task->ins_time = date('Y-m-d H:i:s');
        $task->upd_time = date('Y-m-d H:i:s');
        $task->flag = '1';
        $task->save();

        $data['id'] = $task->id;
        return $data;
    }

    public function editTask(Request $request){
        $data = $request->all();
        $data['date'] = $data['date'] . ' 00:00:00';

        Task::where('id', $data['id'])->update([
            'title' => $data['title'],
            'datetime' => $data['date'],
            'memo' => $data['memo'],
            'category' => $data['category'],
            'upd_time' => date('Y-m-d H:i:s'),
        ]);

        return $data;
    }

    public function deleteTask(Request $request){
        $data = $request->all();

        Task::where('id', $data['id'])->update([
            'upd_time' => date('Y-m-d H:i:s'),
            'flag' => '0'
        ]);

        return $data;;
    }
}
