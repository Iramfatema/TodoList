@extends('layouts.app')

@section('content')
<div class="container">
        <div class="panel panel-default">
            <div class="container my-4">
                <div class="panel-heading"><span style="font-size:20px;">
                    Todo List</span>
                <a href="todo/create">
                <button type="button" class="btn btn-primary btn-lg"
                style="float: right">Add Note</button></a>
                </div>
            </div>
            <div class="container my-3">
                <div class="panel-body">
                    {{session('msg')}}
                    <table class="table" border='1' id="todoTable">
                    <thead>
                        <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Description</th>
                        <th scope="col" style="text-indent: 50px;">Actions</th>
                        </tr>
                    </thead>
                    </table>
                </div>
            </div>
        
        </div>
        <p>Todo app Created successfully</p>
</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> -->

    <script type="text/javascript">
        $(function() {
            $('#todoTable').DataTable({
               // processing: true,
                serverSide: true,
                oSearch: {"bSmart": true},
                "ajax": {
                    'url': '{!!route("todo.list")!!}',
                    'type': 'GET'
                },
                columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'description', name: 'description'},
                        {data: 'action', name: 'action', orderable: true, searchable: true},
                    ]
            });
        });
    </script>
@endsection
