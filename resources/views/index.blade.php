@extends('layouts.container')


@section('main')
    <div class="container mt-2">
        <h2 class="text-center">Tareas</h2>
        <div class="mt-2 mb-3">
            <form id="form-task">
                <label for="new-task">Nueva Tarea</label>
                <input type="text" class="form-control" id="new-task">
                <div class="mt-2 text-center">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
        <div class="border-top" >
            <div class="list-group mt-3" id="list-task">
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/index.js')}}"></script>
@endsection
