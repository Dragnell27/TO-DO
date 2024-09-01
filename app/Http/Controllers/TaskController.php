<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //Retorna la vista para la lista de tareas.
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
            //Extraigo las tareas para el usuario que inicio sesión en orden descendente
            $tasks = Task::where('user_id', $id)
            ->where('status','!=', 3)
            ->orderBy('id', 'desc')
            ->get();

            //Si no ocurre ningún error retorna la información obtenida
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

    //Realiza la actualización de la tarea
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
        //Cambio el estado de la tarea a eliminado en la base de datos
        try {
            $task = Task::find($id);
            $task->status = 3;
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

    //Realiza la actualización de pendiente y completado de las tareas
    public function checkTask(string $id)
    {
        try {
            $task = Task::find($id);

            //Dependiendo del estado que este actualmente la tarea se cambia a pendiente o completada.
            $newStatus = $task->status == 1 ? 2:1;

            //Genero el mensaje según el estado de la tarea. 1 = pendiente, 2 = completada.
            $msg = $task->status == 1 ? 'Tarea marcada como completada' : 'Tarea marcada como pendiente.';

            //Asigno el nuevo estado y guardo la tarea.
            $task->status = $newStatus;
            $task->save();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => $msg,
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
}
