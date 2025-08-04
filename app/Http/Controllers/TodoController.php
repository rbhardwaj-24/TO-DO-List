<?php

namespace App\Http\Controllers;
use App\Models\Task;

use Illuminate\Http\Request;

class TodoController extends Controller
{

    public function index(Request $request){

        // get all the tasks that are yet to be completed
        if($request->ajax()){
            $tasks = Task::where("is_completed",0)->get();
            return response()->json($tasks);
        }

        // get all the tasks to show in all-tasks tabel wether they are completed or not
        $allTasks = Task::all();
        foreach($allTasks as $task){
            $task->is_completed = $task->is_completed == 1 ? 'Completed' : 'Not Completed';
        }
        return view('index',['allTasks' =>$allTasks]);
    }


    public function addTodo(Request $request){

        $existingTask = Task::where('name',$request->name)->first();

        if($existingTask){
            return response()->json([
                'status' => 'error',
                'message' => 'Task already exists!',
            ], 409);
        }

        // Add the new todo(task) in the database
        $data = new Task;
        $data->name = $request->name;
        $data->due_date = $request->date;
        $data->save();

        return response()->json(['status'=>'success']);

    }

    public function markComplete(Request $request)
    {
        // Makr the task completed id=$id from the database
        $todo = Task::find($request->id);
        if($todo){
            $todo->is_completed = 1;
            $todo->save();
            return response()->json([]);
        } else {
            return response()->json(['success' => false], 404);
        }
    }


    public function destroy($id){

        // Delete the task from database with id=$id
        $todo = Task::findOrFail($id);
        $todo->delete();

        return redirect()->back();
    }
}
