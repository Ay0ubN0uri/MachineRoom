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
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>


    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteUserModalLabel">Supprimer l'utilisateur</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Voulez-vous vraiment supprimer cet utilisateur ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" id="deleteUserButton">Supprimer</button>
                </div>
            </div>
        </div>
    </div>      
@stop

@section('css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@stop

@section('js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        
        $(document).ready(function() {
            toastr.options = {
                "positionClass": "toast-top-center", 
            }

            $('#users').DataTable({
                processing: true,
                ajax: '{{ route("user_data") }}',
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
                            var toggle = '<input class="cus_toggle_btn" type="checkbox" data-id="' + row.id +
                            '" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Active" data-off="Disabled" ' 
                            + active + '>';
                            return toggle;
                        },
                    },
                    { 
                        "render": function(data, type, row, meta) {
                            return '<button class="btn btn-danger btn-sm delete-btn" data-id="'+row.id+'"><i class="fa fa-trash"></i></button>';
                        },
                    }
                ],
                fnDrawCallback: function() {
                    $('.cus_toggle_btn').each(function(index, element){
                        $(element).bootstrapToggle();
                    })
                },
            });

            $(document).on('change', '[data-toggle="toggle"]', function() {
                var id = $(this).data('id');
                if(id){
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
                }
            });

            $("#users").on('click', '.delete-btn', function() {
                let userId = $(this).data('id');
                $('#deleteUserModal').modal('show');
                $('#deleteUserButton').click(function() {
                    let $this = $(this);
                    $this.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> En cours...').addClass('disabled');
                    $.ajax({
                        url: '/deleteuser/' + userId,
                        type: 'POST',
                        data: {_method: 'DELETE', _token: '{{ csrf_token() }}'},
                        success: function (data) {
                            $('#users').DataTable().ajax.reload();
                            $('#deleteUserModal').modal('hide');
                            toastr.success(data.success);
                            $this.html('Supprimer').removeClass('disabled');
                        },
                        error: function(error){
                            toastr.error(error.error);
                        }
                    });
                });
            });
        });
    </script>

@stop


