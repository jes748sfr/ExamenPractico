<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Rules\TasksPerUser;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        try {

            $task = Task::with(['user'])->get();

            return response()->json($task,200);
        }catch (\Exception $e) {
            return response()->json([
            'error' => 'Error al cargar las tareas.',
            'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'is_completed' => ['required', 'boolean'],
            'start_at' => ['required', 'string'],
            'expired_at' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id', new TasksPerUser()],
            'company_id' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'La validación ha fallado.',
                'errors' => $validator->errors(),
            ], 422);
        }

         try {

            $task = new Task();

            $task->name = $request->name;
            $task->description = $request->description;
            $task->is_completed = $request->is_completed;
            $task->start_at = Carbon::parse($request->start_at);
            $task->expired_at = Carbon::parse($request->expired_at);
            $task->user_id = $request->user_id;
            $task->company_id = $request->company_id;

            $task->save();

            return response()->json(['Task' => $task], 201);

        }catch (\Exception $e) {
            return response()->json([
            'error' => 'Error al guardar la tarea.',
            'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function update(Request $request, $id)
    {

        $request->validate([
        'name' => ['required', 'string'],
        'description' => ['required', 'string'],
        'is_completed' => ['required', 'boolean'],
        'start_at' => ['required', 'string'],
        'expired_at' => ['required', 'string'],
        ]);

        try {
            $task = Task::find($id);

            if (!$task) {
                return response()->json(['message' => 'Task not found'], 404);
            }

            $task->name = $request->name;
            $task->description = $request->description;
            $task->is_completed = $request->is_completed;
            $task->start_at = Carbon::parse( $request->start_at);
            $task->expired_at = Carbon::parse($request->expired_at);

            $task->save();

            return response()->json(['task' => $task], 200);

        } catch (\Exception $e) {
            return response()->json([
            'error' => 'Error al editar la tarea.',
            'message' => $e->getMessage(),
            ], 500);
        }
        
    }

    public function delete($id)
    {
        try {
            $task = Task::findOrFail($id);

            if (!$task) {
                return response()->json(['message' => 'Task not found'], 404);
            }

            $task->delete();

            return response()->json(['Task deleted succesfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
            'error' => 'Error al eliminar la tarea.',
            'message' => $e->getMessage(),
            ], 500);
        }
    }

}
