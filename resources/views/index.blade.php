@include("components.header")

<body>

    <div class="container d-flex justify-content-center my-5">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header text-center">
                    <h3>To-Do List App</h3>
                </div>
                <div class="card-body">

                    {{-- Form to add a todo --}}
                    @include("components.add_todo_form")

                    <hr>

                    {{-- Table to show the todo's not completed --}}
                    {{-- @include("components.todo_list") --}}
                    <table class="table text-center">
                        <thead>
                            <tr>
                            <th scope="col">To-Do Item</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Mark as complete</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider" id="todo_list">


                        </tbody>
                    </table>

                    {{-- Table to show all the todo's on button click --}}
                    @include("components.show-all-tasks")

                </div>
            </div>
        </div>
    </div>

    {{-- jQuery CDN --}}
    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous">
    </script>

    {{-- Bootstrap JS CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

    {{-- Font Awesome JS CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">

        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            fetchTodos();

            $("#add-todo-form").on("submit",function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{ url('add-todo') }}",
                    type: "post",
                    data: jQuery('#add-todo-form').serialize(),
                    success: function (response) {
                        if(response.status === 'success'){
                            jQuery("#add-todo-form")[0].reset();
                            fetchTodos();
                        }
                    },
                    error: function(xhr){
                        if(xhr.status === 409){
                            alert('Task already exists!')
                        }
                    }
                });
            });

            function fetchTodos()
            {
                $.ajax({
                    type: 'get',
                    url: "{{ url('/') }}",
                    success: function (response) {
                        // console.log(response)
                        let row = "";
                        $.each(response, function (key, task) {
                            row += `
                            <tr>
                                <td>${task.name}</td>
                                <td>${task.due_date}</td>
                                <td><input type="checkbox" class="complete-task" data-id="${task.id}"></td>
                            </tr>`;
                        });

                        $('#todo_list').empty().append(row);
                    }
                })
            }

            $(document).on('change', '.complete-task', function() {
                let taskId = $(this).attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/mark-complete') }}",
                    data: {id: taskId},
                    success: function(response){
                        fetchTodos();
                    }
                })

            });
        });

    </script>

</body>
</html>
