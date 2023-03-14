@extends('adminlte::page')

@section('title', 'Gestion des utilisateurs')

@section('content_header')
    <h1>Machines Management</h1>
@stop


@section('content')
    <div class="card">
        <div class="card-body">
            <div class="m-2">
                <button type="button" class="btn btn-primary create-room" data-toggle="modal" data-target="#create-room">
                    Create Machine
                  </button>
            </div>
              
              <!-- Create Modal -->
              <div class="modal fade" id="create-machine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Create Machine</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form data-route="{{route('admin.machines.store')}}" method="POST" class="create-form">
                    <div class="modal-body">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="Reference" class="form-label">Reference</label>
                                    <input type="textarea" name="reference" class="form-control" id="reference_create_input" placeholder="Enter a code" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="brand" class="form-label">Brand</label>
                                    <input type="textarea" name="brand" class="form-control" id="brand_create_input" placeholder="Enter a label" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-outline-warning">Reset</button>
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-success">Create Room</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            
            <table id="rooms" class="table table-hover table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Reference</th>
                        <th>Brand</th>
                        <th>purchaseDate</th>
                        <th>Price</th>
                        {{-- <th>Room</th> --}}
                        <th>Delete</th>
                        <th>Edit</th>
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
            var toast = Swal.mixin({
                toast: true,
                icon: 'success',
                title: 'General Title',
                animation: false,
                position: 'top',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            $('#rooms').DataTable({
                processing: true,
                ajax: '{{ route("admin.fetchMachines") }}',
                columns: [
                    {data: 'id'},
                    {data: 'reference'},
                    {data: 'brand'},
                    {data: 'purchaseDate'},
                    {data: 'price'},
                    { 
                        "data": "Action",
                        "render": function(data, type, row, meta) {
                            return `<button data-id="${row.id}" class="deleteBtn btn btn-outline-danger">Delete</button>`;
                        },
                    },
                    { 
                        "data": "Action",
                        "render": function(data, type, row, meta) {
                            return `<button data-id="${row.id}" class="editBtn btn btn-outline-success">Edit</button>`;
                        },
                    }
                ],
            });

            // $(document).on('click', '.deleteBtn', function() {
            //     console.log($('meta[name="csrf-token"]').attr('content'));
            //     var id = $(this).data('id');
            //     console.log(id);
            //     $.ajax({
            //         url: `rooms/${id}`,
            //         type: 'POST',
            //         data: {
            //             '_method': 'DELETE'
            //         },
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         success: function(data) {
            //             console.log(data);
            //             toast.fire({
            //                 animation: true,
            //                 title: 'Room Successfully Deleted'
            //             });
            //             $('#rooms').DataTable().ajax.reload();
            //         },
            //         error: function(xhr, status, error) {
            //             console.log(xhr.responseText);
            //         }
            //     });
            // });


            // $(document).on('click', '.editBtn', function() {
            //     var id = $(this).data('id');
            //     var code = $(this).closest('tr').find('td').eq(1).text();
            //     var label = $(this).closest('tr').find('td').eq(2).text();
            //     $('#code_edit_input').val(code);
            //     $('#label_edit_input').val(label);
            //     $('#edit-room').modal('show');
            //     $('.edit-form').data('id',id);
            // });

            // $(document).on('submit','.create-form',function(e){
            //     e.preventDefault();
            //     console.log($(this));
            //     var formData = $(this).serialize();
            //     $.ajax({
            //         url: $(this).data('route'),
            //         type: 'POST',
            //         data: formData,
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         success: function(data) {
            //             console.log(data);
            //             $('#code_create_input').val('');
            //             $('#label_create_input').val('');
            //             $('#create-room').modal('hide');
            //             toast.fire({
            //                 animation: true,
            //                 title: 'Room Successfully Created'
            //             });
            //             $('#rooms').DataTable().ajax.reload();
            //         },
            //         error: function(xhr, status, error) {
            //             console.log(xhr.responseText);
            //         }
            //     });
            // });

            // $(document).on('submit','.edit-form',function(e){
            //     e.preventDefault();
            //     console.log($(this));
            //     var formData = $(this).serialize();
            //     console.log(formData);
            //     $.ajax({
            //         url: `rooms/${$('.edit-form').data('id')}`,
            //         type: 'POST',
            //         data: formData,
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         success: function(data) {
            //             console.log(data);
            //             $('#code_edit_input').val('');
            //             $('#label_edit_input').val('');
            //             $('#edit-room').modal('hide');
            //             toast.fire({
            //                 animation: true,
            //                 title: 'Room Successfully Edited'
            //             });
            //             $('#rooms').DataTable().ajax.reload();
            //         },
            //         error: function(xhr, status, error) {
            //             console.log(xhr.responseText);
            //         }
            //     });
            // });
        });



    </script>

@stop


