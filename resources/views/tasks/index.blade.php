@extends('layouts.app')

@section('content')

        <!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

            <!-- New Task Form -->
    <form action="{{ url('tasks/task') }}" method="POST" class="form-horizontal">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <!-- Task Name -->
        <div class="form-group">
            <label for="task" class="col-sm-3 control-label">Task</label>

            <div class="col-sm-6">
                <input type="text" name="name" id="task-name" class="form-control">
            </div>
        </div>

        <!-- Add Task Button -->
        @include('tasks.partials.addbutton')
    </form>
</div>

<!-- Current Tasks -->
@include('tasks.partials.tasks_list')
@endsection