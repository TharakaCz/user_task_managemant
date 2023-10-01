<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
    }

    public function create(Request $request)
    {
        try {
            $rules = Validator::make($request->all(), [
                "title" => "required|string",
                "description" => "required|string"
            ]);

            if ($rules->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $rules->errors()
                ], 401);
            }

            $task = new Task();
            $task->user_id = auth()->user()->id;
            $task->title = $request->title;
            $task->description = $request->description;

            if (!$task->save()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Task create faild',
                ], 500);
            }

            return response()->json([
                'status' => true,
                'message' => 'Task created',
            ], 500);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $rules = Validator::make($request->all(), [
                "id" => "required|numeric",
                "title" => "required|string",
                "description" => "required|string",
            ]);

            if ($rules->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $rules->errors()
                ], 401);
            }

            if (!Task::where('id', $request->id)->update([
                'title' => $request->title,
                'description' => $request->description
            ])) {
                return response()->json([
                    'status' => false,
                    'message' => "Task update faild.",
                ], 500);
            }

            return response()->json([
                'status' => true,
                'message' => "Task updated.",
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $rules = Validator::make($request->all(), [
                "id" => "required|numeric"
            ]);

            if ($rules->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $rules->errors()
                ], 401);
            }

            if (!Task::where('id', $request->id)->delete()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Task delete faild',
                ], 500);
            }

            return response()->json([
                'status' => true,
                'message' => 'Task delete success.',
            ], 500);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getAll()
    {
        try {
            $task = Task::all();

            if (count($task) > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'User Task List',
                    'data' => $task,
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'No user task available this time.',
                'data' => null,
            ], 401);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getTask()
    {
        try {
            $user = User::where('id', auth()->user()->id)->with('task')->get();

            if (count($user) > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'User Task List',
                    'data' => $user,
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'No task this time.',
                'data' => null,
            ], 500);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
