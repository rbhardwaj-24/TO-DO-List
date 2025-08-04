<form class="my-3" action="" method="POST" id="add-todo-form">
    @csrf
    <div class="row">
        <div class="col-6">
            <input name="name" placeholder="Enter To-do" type="text" class="form-control">
        </div>
        <div class="col-4">
            <input name="date" type="date" class="form-control">
        </div>
        <button type="submit" class="btn btn-success col-2">Add</button>
    </div>
</form>

