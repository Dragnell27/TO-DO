<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(Request $request)
    {
        try {
            //Creo el objeto task
            $task = new Task();

            //asigno los atributos del objeto task
            $task->task = $request->task;
            $task->status = 1;
            $task->user_id = $request->id;

            //Guardo la tarea en la base de datos
            $task->save();

            //Retorno mensaje para alerta
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Tarea agregada correctamente',
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Ocurrió un error al guardar la tarea.',
                    'error' => $e->getMessage(),
                ],
                500
            );
        }
    }

    public function show($id)
    {
        try {
            $tasks = Task::where('user_id', $id)->where('status', 1)->get();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Tareas obtenidas correctamente',
                    'data' => $tasks,
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Error al obtener los datos.',
                    'error' => $e->getMessage(),
                ],
                500
            );
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $task = Task::find($id);
            $task->task = $request->task;
            $task->save();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Tarea actualizada correctamente',
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Ocurrió un error al actualizar la tarea.',
                    'error' => $e->getMessage(),
                ],
                500
            );
        }
    }

    public function destroy($id)
    {
        try {
            $task = Task::find($id);
        $task->status = 2;
        $task->save();

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Tarea eliminada correctamente',
            ],
            200
        );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Ocurrió un error al eliminar la tarea.',
                    'error' => $e->getMessage(),
                ],
                500
            );
        }
    }
}
