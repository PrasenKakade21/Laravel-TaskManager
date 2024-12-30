@extends('layout.baseview')
@section('title', 'All Tasks')

@section('content')
    @include('layout.css')
    @include('layout.js')
    @include('layout.navigation')

    <div class="container my-4">
        <!-- Button to trigger the modal -->
        <div class="d-flex justify-content-between align-items-center">
        <h2 class="mb-4">Task Table</h2>
        <button type="button" class="btn btn-primary" onclick="showCreateTask()">
            Create Task
        </button>
    </div>
        <table class="table table-striped table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Task Description</th>
                    <th>Task Owner</th>
                    <th>Task ETA</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tasktable">

            </tbody>
        </table>
    </div>





    <!-- Modal -->
    <div class="modal fade" id="createTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTaskModalLabel">Create Task</h5>
                    <button type="button" class="btn-close" onclick="hideCreateTask()"></button>
                </div>
                <div class="modal-body">
                    <form id="taskForm">
                        <div class="mb-3">
                            <label for="taskDescription" class="form-label">Task Description</label>
                            <textarea class="form-control" id="taskDescription" rows="3" placeholder="Enter task description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="taskOwner" class="form-label">Task Owner</label>
                            <input type="text" class="form-control" id="taskOwner" placeholder="Enter task owner name">
                        </div>
                        <div class="mb-3">
                            <label for="taskOwnerEmail" class="form-label">Task Owner Email</label>
                            <input type="email" class="form-control" id="taskOwnerEmail"
                                placeholder="Enter task owner email">
                        </div>
                        <div class="mb-3">
                            <label for="taskETA" class="form-label">Task ETA</label>
                            <input type="date" class="form-control" id="taskETA">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="hideCreateTask()">Close</button>
                    <button type="button" class="btn btn-primary" id="saveTaskButton" onclick="createTask()">Save
                        Task</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Task Edit Form -->
                    <form id="editTaskForm">
                        <div class="mb-3">
                            <label for="editTaskDescription" class="form-label">Task Description</label>
                            <textarea class="form-control" id="editTaskDescription" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editTaskOwner" class="form-label">Task Owner</label>
                            <input type="text" class="form-control" id="editTaskOwner">
                        </div>
                        <div class="mb-3">
                            <label for="editTaskOwnerEmail" class="form-label">Task Owner Email</label>
                            <input type="email" class="form-control" id="editTaskOwnerEmail">
                        </div>
                        <div class="mb-3">
                            <label for="editTaskETA" class="form-label">Task ETA</label>
                            <input type="date" class="form-control" id="editTaskETA">
                        </div>
                        <div class="mb-3">
                            <label for="editTaskStatus" class="form-label">Task Status</label>
                            <select class="form-select" id="editTaskStatus">
                                <option value="0">In Progress</option>
                                <option value="1">Completed</option>
                            </select>
                        </div>
                        <input type="hidden" id="editTaskId">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveEditButton" onclick="updateTask()">Save
                        Changes</button>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Mark Task as Done Modal -->
    <div class="modal fade" id="markTaskDoneModal" tabindex="-1" aria-labelledby="markTaskDoneModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="markTaskDoneModalLabel">Mark Task as Done</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <input type="hidden" id="doneTaskId">
                </div>
                <div class="modal-body">
                    Are you sure you want to mark the task <strong><span id="markTaskDesc"></span></strong> as
                    <strong>Done</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirmMarkDoneButton" onclick="updateStatus()">Mark Done</button>
                </div>
            </div>
        </div>
    </div>
        <!-- Delete Task Modal -->
        <div class="modal fade" id="deleteTaskModal" tabindex="-1" aria-labelledby="deleteTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteTaskModalLabel">Delete Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <input type="hidden" id="deleteTaskId">
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete the task <strong><span id="deleteTaskDesc"></span></strong>?
                        <p class="text-danger mt-2">This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteButton" onclick="deleteTask()">Delete</button>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('customjs')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            console.log(1)
            getAllTasks();
        });

        function getAllTasks() {

            $.ajax({

                type: 'get',
                url: 'http://localhost:8000/api/tasks',
                success: function(result) {
                    var html = '';

                    for (let i = 0; i < result.length; i++) {
                        var status = (result[i]['status'] == 1) ? "Completed" : "In Progress"
                        var strike = (result[i]['status'] == 1) ? 'class="text-decoration-line-through"' : ""
                        html += '<tr>' +
                            '<th scope="row">' + (i + 1) + '</th>' +
                            '<td '+strike+'>' + result[i]['task_description'] + '</td>' +
                            '<td '+strike+'>' + result[i]['task_owner'] + '</td>' +
                            '<td '+strike+'>' + result[i]['task_eta'] + '</td>' +
                            '<td '+strike+'>' + status + '</td>' +
                            '<td>' +
                            '<i class="bi bi-pencil-square text-primary me-2" title="Edit" onclick="editTask(' +
                            result[i]['id'] + ')"></i>' +
                            '<i class="bi bi-check2-square text-success me-2" title="Complete" onclick="markAsDone(' +
                            result[i]['id'] + ')"></i>' +
                            '<i class="bi bi-trash text-danger" title="Delete" onclick="getDeleteTask(' + result[i]
                            [
                                'id'
                            ] + ')"></i>' +
                            '</td>' +
                            '</tr>';
                    }
                    $("#tasktable").html(html)

                },

                error: function(e) {
                    console.log(e.responseText)
                }
            })
        }

        function showCreateTask() {
            $('#createTaskModal').modal("show");
        }

        function hideCreateTask() {
            $('#createTaskModal').modal("hide");
        }

        function createTask() {
            const taskDescription = $('#taskDescription').val();
            const taskOwner = $('#taskOwner').val();
            const taskOwnerEmail = $('#taskOwnerEmail').val();
            const taskETA = $('#taskETA').val();
            console.log("hi");
            if (taskDescription && taskOwner && taskOwnerEmail && taskETA) {

                $.ajax({

                    type: 'post',
                    url: 'http://localhost:8000/api/task',
                    data: {
                        task_description: taskDescription,
                        task_owner: taskOwner,
                        task_owner_email: taskOwnerEmail,
                        task_eta: taskETA
                    },
                    success: function(result) {
                        alert("Task Created")
                        $('#createTaskModal').modal("hide");
                        getAllTasks();

                    },
                    error: function(err) {
                        console.log(err.responseText)
                    }
                })
            } else {
                alert('Please fill in all fields!');
            }

        }

        function editTask(id) {
            $.ajax({

                type: 'get',
                url: 'http://localhost:8000/api/task/' + id,

                success: function(result) {
                    $('#editTaskDescription').val(result['task_description'])
                    $('#editTaskOwner').val(result['task_owner'])
                    $('#editTaskOwnerEmail').val(result['task_owner_email'])
                    $('#editTaskETA').val(result['task_eta'])
                    $('#editTaskStatus').val(result['status'])
                    $('#editTaskId').val(result['id'])
                },
                error: function(err) {
                    console.log(err.responseText)
                }
            })


            $('#editTaskModal').modal("show");
        }

        function updateTask() {

            var task_description = $('#editTaskDescription').val()
            var task_owner = $('#editTaskOwner').val()
            var task_owner_email = $('#editTaskOwnerEmail').val()
            var task_eta = $('#editTaskETA').val()
            var status = $('#editTaskStatus').val()
            var id = $('#editTaskId').val()
            $.ajax({

                type: 'put',
                url: 'http://localhost:8000/api/task/' + id,

                data: {
                    task_description: task_description,
                    task_owner: task_owner,
                    task_owner_email: task_owner_email,
                    task_eta: task_eta,
                    status: status
                },
                success: function(result) {
                    alert("Task Edited")
                    $('#editTaskModal').modal("hide");
                    getAllTasks();

                },
                error: function(err) {
                    console.log(err.responseText)
                }
            })


            $('#editTaskModal').modal("show");
        }

        function markAsDone(id) {
            $('#doneTaskId').val(id)
            $('#markTaskDoneModal').modal("show");
        }

        function updateStatus() {
            var status = 1;
            var id = $('#doneTaskId').val();
            $.ajax({

                type: 'post',
                url: 'http://localhost:8000/api/task/done/' + id,

                data: {
                    status: status
                },
                success: function(result) {
                    alert("Task Marked Complete")
                    $('#markTaskDoneModal').modal("hide");
                    getAllTasks();

                },
                error: function(err) {
                    console.log(err.responseText)
                }
            })
        }
        function getDeleteTask(id) {
            $('#deleteTaskId').val(id)
            $('#deleteTaskModal').modal("show");
        }

        function deleteTask() {
            var id = $('#deleteTaskId').val();
            $.ajax({
                type: 'delete',
                url: 'http://localhost:8000/api/task/' + id,

                data: {
                    id: id
                },
                success: function(result) {
                    alert("Task Deleted")
                    $('#deleteTaskModal').modal("hide");
                    getAllTasks();

                },
                error: function(err) {
                    console.log(err.responseText)
                }
            })
        }
    </script>
@endsection
