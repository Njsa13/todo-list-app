<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <style>
        .list {

            border-radius: 15px;
            padding: 6px 20px;
            box-shadow: 2px 2px 6px 2px rgba(0, 0, 0, 0.3);
        }

        .title,
        .subtitle {
            text-align: center;
        }

        .subtitle {
            font-size: 20px;
        }

        .list-body {
            margin-top: 20px;
        }

        .btn {
            margin-bottom: 20px
        }

        .modal-content {
            margin: 250px auto;
            padding: 10px 20px;
            width: 800px;
        }

        .modal {
            background-color: rgba(0, 0, 0, 0.3)
        }

        .close {
            float: right;
            font-size: 28px;
            cursor: pointer;
        }

        .action {
            display: flex;
            justify-content: center;
            gap: 6px;
        }

        .content {
            margin-bottom: 30px
        }
    </style>

    <title>Todo List App</title>
</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand">
                    <span class="glyphicon glyphicon-th-large"></span> ToDo List
                </a>
            </div>
        </div>
    </nav>
    <main class="content">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="list">
                        <div class="list-head">
                            <h1 class="title">
                                Welcome To ToDo List
                            </h1>
                            <p class="subtitle">Here Your List</p>
                        </div>
                        <div class="list-body">
                            <button id="add-task" class="btn btn-primary">
                                <span class="glyphicon glyphicon-plus"></span> Add Task
                            </button>
                            <table id="tasks-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>Title</th>
                                        <th>Is Done</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div id="add-modal" class="add-modal modal">
        <div class="modal-content">
            <span id="add-close" class="close">&times;</span>
            <h2>New Task</h2>
            <form id="task-form">
                <div class="form-group">
                    <label for="title-input">Title</label>
                    <input type="text" class="form-control" id="title-input" autocomplete="off"
                        placeholder="Type your taks here">
                </div>
                <button id="submit-task" type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
    <div id="edit-modal" class="edit-modal modal">
        <div class="modal-content">
            <span id="edit-close" class="close">&times;</span>
            <h2>Edit Task</h2>
            <form id="edit-task-form">
                <div class="form-group">
                    <label for="edit-title-input">Title</label>
                    <input type="text" class="form-control" id="edit-title-input" autocomplete="off"
                        placeholder="Type your taks here">
                </div>
                <input type="hidden" id="edit-data-id">
                <button id="edit-submit-task" type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var tasksTable = $('#tasks-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('tasks') }}',
                columns: [{
                        data: null,
                        name: 'no',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: null,
                        name: 'is_done',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: null,
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'desc']
                ],
                columnDefs: [{
                    targets: 0,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, {
                    targets: 3,
                    render: function(data, type, row) {
                        return row.is_done ? '✅' : '❌';
                    }
                }, {
                    targets: 4,
                    render: function(data, type, row) {
                        let changeStatusBtn = null;
                        if (row.is_done) {
                            changeStatusBtn = '<button type="button" value="' + row.id +
                                '" class="btn-change-status btn btn-xs btn-warning">' +
                                '<span class="glyphicon glyphicon-repeat"></span>' +
                                '</button>';
                        } else {
                            changeStatusBtn = '<button type="button" value="' + row.id +
                                '" class="btn-change-status btn btn-xs btn-success">' +
                                '<span class="glyphicon glyphicon-ok"></span>' +
                                '</button>';
                        }
                        return '<div class="action">' +
                            '<button type="button" value="' + row.id +
                            '" class="btn-edit btn btn-xs btn-primary">' +
                            '<span class="glyphicon glyphicon-edit"></span>' +
                            '</button>' +
                            '<button type="button" value="' + row.id +
                            '" class="btn-delete btn btn-xs btn-danger">' +
                            '<span class="glyphicon glyphicon-trash"></span>' +
                            '</button>' +
                            changeStatusBtn +
                            '</div>';
                    }
                }]
            });

            $('#add-task').click(function() {
                $('#add-modal').fadeIn();
            });

            $('#add-close').click(function() {
                $('#add-modal').fadeOut();
            });

            $('#task-form').submit(function(e) {
                $('#submit-task').prop('disabled', true);
                e.preventDefault();
                $.ajax({
                    url: '{{ url('task') }}',
                    type: 'POST',
                    data: {
                        title: $('#title-input').val()
                    },
                    success: function(res) {
                        iziToast.success({
                            title: 'Success',
                            message: 'Data successfully saved',
                            position: 'topCenter'
                        });
                        tasksTable.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        console.log("Req error: ", xhr.responseJSON);
                        iziToast.error({
                            title: 'Error ' + xhr.status,
                            message: xhr.status == 500 ? 'Data failed to save' : xhr
                                .responseJSON.error,
                            position: 'topCenter'
                        });
                    }
                });
                $('#submit-task').prop('disabled', false);
                $('#title-input').val('');
                $('#add-modal').fadeOut();
            });

            $('#tasks-table').on('click', '.btn-edit', function() {
                $('#edit-modal').fadeIn();
                const id = $(this).val();
                $('#edit-data-id').val(id);
            });

            $('#edit-close').click(function() {
                $('#edit-modal').fadeOut();
                $('#edit-data-id').val('');
            });

            $('#edit-task-form').submit(function(e) {
                const id = $('#edit-data-id').val();
                $('#edit-submit-task').prop('disabled', true);
                e.preventDefault();
                $.ajax({
                    url: '{{ url('task') }}/' + id,
                    type: 'PATCH',
                    data: {
                        title: $('#edit-title-input').val()
                    },
                    success: function(res) {
                        iziToast.success({
                            title: 'Success',
                            message: 'Data successfully updated',
                            position: 'topCenter'
                        });
                        tasksTable.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        console.log("Req error: ", xhr.responseJSON);
                        iziToast.error({
                            title: 'Error ' + xhr.status,
                            message: xhr.status == 500 ? 'Data failed to update' : xhr
                                .responseJSON.error,
                            position: 'topCenter'
                        });
                    }
                });
                $('#edit-submit-task').prop('disabled', false);
                $('#edit-title-input').val('');
                $('#edit-modal').fadeOut();
            });

            $('#tasks-table').on('click', '.btn-delete', function() {
                const id = $(this).val();
                $(this).prop('disabled', true);
                $.ajax({
                    url: '{{ url('task') }}/' + id,
                    type: 'DELETE',
                    success: function(res) {
                        iziToast.success({
                            title: 'Success',
                            message: 'Data successfully deleted',
                            position: 'topCenter'
                        });
                        tasksTable.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        console.log("Req error: ", xhr.responseJSON);
                        iziToast.error({
                            title: 'Error ' + xhr.status,
                            message: xhr.status == 500 ? 'Data failed to delete' : xhr
                                .responseJSON.error,
                            position: 'topCenter'
                        });
                    }
                });
                $(this).prop('disabled', false);
            });

            $('#tasks-table').on('click', '.btn-change-status', function() {
                const id = $(this).val();
                $(this).prop('disabled', true);
                $.ajax({
                    url: '{{ url('task/change-status') }}/' + id,
                    type: 'PATCH',
                    success: function(res) {
                        iziToast.success({
                            title: 'Success',
                            message: 'Status data successfully changed',
                            position: 'topCenter'
                        });
                        tasksTable.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        console.log("Req error: ", xhr.responseJSON);
                        iziToast.error({
                            title: 'Error ' + xhr.status,
                            message: xhr.status == 500 ?
                                'Status sata failed to change' : xhr.responseJSON.error,
                            position: 'topCenter'
                        });
                    }
                });
                $(this).prop('disabled', false);
            });
        });
    </script>
</body>

</html>
