<form action="{{ url('tasks/task/' . $task->id) }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="DELETE">

    <button type="submit" class="btn btn-danger">
        <i class="glyphicon glyphicon-trash"></i> Delete
    </button>
</form>
