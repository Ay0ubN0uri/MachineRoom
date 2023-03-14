@extends('adminlte::page')

@section('title', 'Gestion des utilisateurs')

@section('content_header')
    <h1>Gestion des utilisateurs</h1>
@stop


@section('content')
    <div class="card">
        <div class="card-body">
            <table id="rooms" class="table table-hover table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Label</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#rooms').DataTable({
                processing: true,
                ajax: '{{ route("admin.fetchRooms") }}',
                columns: [
                    {data: 'id'},
                    {data: 'code'},
                    {data: 'label'},
                    { 
                        "data": "Action",
                        "render": function(data, type, row, meta) {
                            // return `<form  action="{{ route('admin.rooms.destroy',['room' => '1']) }}" method="POST">
                            //     @csrf
                            //     @method('DELETE')
                            //     <input class="btn btn-danger" type="submit" value="Delete">
                            // </form>`;
                            return `<button data-id="${row.id}" class="deleteBtn w-50 m-auto btn btn-outline-danger">Delete</button>`;
                        },
                    }
                ],
            });

            $(document).on('click', '.deleteBtn', function() {
                console.log($('meta[name="csrf-token"]').attr('content'));
                var id = $(this).data('id');
                console.log(id);
                $.ajax({
                    url: `rooms/${id}`,
                    type: 'POST',
                    data: {
                        '_method': 'DELETE'
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        console.log(data);
                        $('#rooms').DataTable().ajax.reload();
                        // $('#users').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
    
                // $.ajax({
                //     url: `/activate/${id}`,
                //     type: 'PUT',
                //     data: {status: status },
                //     success: function(data) {
                //         console.log(data);
                //         $('#users').DataTable().ajax.reload();
                //     },
                //     error: function(xhr, status, error) {
                //         console.log(xhr.responseText);
                //     }
                // });
            });
        });



    </script>

@stop


