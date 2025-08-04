<p class="d-inline-flex gap-1 float-end">
    <div class="d-grid gap-2">
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Show all tasks<i class="fa-regular fa-circle-down fa-xl mx-2"></i>
        </button>
    </div>
</p>
<div class="collapse" id="collapseExample">
    <div class="card card-body">
        <table class="table text-center">
            <thead>
                <tr>
                <th scope="col">To-Do Item</th>
                <th scope="col">Due Date</th>
                <th scope="col">Completed</th>
                <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody class="table-group-divider" id="todo_list">

                @foreach ($allTasks as $task)
                    <tr>
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->due_date }}</td>
                        <td>{{ $task->is_completed }}</td>
                        <td>
                            <form action="{{ route('todos.destroy',$task->id) }}" onsubmit="return confirm('Are you sure to delete this task?')" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
