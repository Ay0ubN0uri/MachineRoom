@extends('adminlte::page')

@section('title', 'Gestion des utilisateurs')

@section('content_header')
    <h1>Gestion des utilisateurs</h1>
@stop


@section('content')
    <div class="card">
        <div class="card-body">
            <table id="users" class="table table-hover table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Etat</th>
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
            $('#users').DataTable({
                processing: true,
                ajax: '{{ route('user_data') }}',
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'created_at'},
                    {data: 'updated_at'},
                    { 
                        "data": "status",
                        "render": function(data, type, row, meta) {
                            var active = data == 'active' ? 'checked' : '';
                            var toggle = '<input id="cus_toggle_btn" type="checkbox" data-id="' + row.id +
                            '" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Active" data-off="Disabled" ' 
                            + active + '>';
                            return toggle;
                        },
                    }
                ],
                fnDrawCallback: function() {
                    $('#cus_toggle_btn').bootstrapToggle();
                },
            });

            $(document).on('change', '[data-toggle="toggle"]', function() {
                var id = $(this).data('id');
                var status = $(this).prop('checked') ? 'active' : 'disabled';
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
    
                $.ajax({
                    url: `/activate/${id}`,
                    type: 'PUT',
                    data: {status: status },
                    success: function(data) {
                        console.log(data);
                        $('#users').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });



    </script>

@stop


