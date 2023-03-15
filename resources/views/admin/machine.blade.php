@extends('adminlte::page')

@section('title', 'Gestion des utilisateurs')

@section('content_header')
    <h1>Machines Management</h1>
@stop


@section('content')
    <div class="card">
        <div class="card-body">
            <div class="mx-2 mb-3">
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-primary " id ="create-machine-btn" data-toggle="modal" data-target="#create-machine">
                        <i class="fa fa-plus"></i><span class="mx-2">Create Machine</span>
                    </button>
                </div>
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
                                    <input type="textarea" name="reference" class="form-control" id="reference_create_input" placeholder="Enter a reference" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="brand" class="form-label">Brand</label>
                                    <input type="textarea" name="brand" class="form-control" id="brand_create_input" placeholder="Enter a brand" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="purchaseDate" class="form-label">Purchase Date</label>
                                    <input type="date" name="purchaseDate" class="form-control" id="purchaseDate_create_input" placeholder="Enter a purchase date" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="text" name="price" class="form-control" id="price_create_input" placeholder="Enter a price" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="room_id" class="form-label">Select a Room</label>
                                    <select class="form-control" id="room_id_create_select" name="room_id">
                                      </select>                                  
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



              <!-- Edit Modal -->
              <div class="modal fade" id="edit-machine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit Machine</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form data-route="{{route('admin.machines.store')}}" method="POST" class="edit-form">
                    <div class="modal-body">
                            @csrf
                            <input type="hidden" name="_method" value="put">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="Reference" class="form-label">Reference</label>
                                    <input type="textarea" name="reference" class="form-control" id="reference_edit_input" placeholder="Enter a reference" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="brand" class="form-label">Brand</label>
                                    <input type="textarea" name="brand" class="form-control" id="brand_edit_input" placeholder="Enter a brand" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="purchaseDate" class="form-label">Purchase Date</label>
                                    <input type="date" name="purchaseDate" class="form-control" id="purchaseDate_edit_input" placeholder="Enter a purchase date" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="text" name="price" class="form-control" id="price_edit_input" placeholder="Enter a price" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="room_id" class="form-label">Select a Room</label>
                                    <select class="form-control" id="room_id_edit_select" name="room_id">
                                      </select>                                  
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-outline-warning">Reset</button>
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-success">Edit Room</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            
            <table id="machines" class="table table-hover table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Reference</th>
                        <th>Brand</th>
                        <th>purchaseDate</th>
                        <th>Price</th>
                        <th>Room</th>
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
            $('#machines').DataTable({
                processing: true,
                ajax: '{{ route("admin.fetchMachines") }}',
                columns: [
                    {data: 'id'},
                    {data: 'reference'},
                    {data: 'brand'},
                    {data: 'purchaseDate'},
                    {data: 'price'},
                    {data: 'room_id'},
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

            $(document).on('click', '.deleteBtn', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: `machines/${id}`,
                    type: 'POST',
                    data: {
                        '_method': 'DELETE'
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        toast.fire({
                            animation: true,
                            title: 'Machine Successfully Deleted'
                        });
                        $('#machines').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });


            $(document).on('click', '.editBtn', function() {
                $('#room_id_edit_select').empty();
                var id = $(this).data('id');
                var reference = $(this).closest('tr').find('td').eq(1).text();
                var brand = $(this).closest('tr').find('td').eq(2).text();
                var purchaseDate = $(this).closest('tr').find('td').eq(3).text();
                var price = $(this).closest('tr').find('td').eq(4).text();
                var room_id = $(this).closest('tr').find('td').eq(5).text();
                $.ajax({
                    url: '{{ route("admin.fetchRooms") }}',
                    type: 'GET',
                    success: function(data) {
                        $.each(data.data, function(key, value) {   
                            $('#room_id_edit_select')
                                .append($("<option></option>")
                                            .attr("value", value.id)
                                            .text(value.label)); 
                        });
                        $('#reference_edit_input').val(reference);
                        $('#brand_edit_input').val(brand);
                        $('#purchaseDate_edit_input').val(purchaseDate);
                        $('#price_edit_input').val(price);
                        $('#room_id_edit_select').val(room_id);
                        $('#edit-machine').modal('show');
                        $('.edit-form').data('id',id);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });

            $(document).on('click','#create-machine-btn',e=>{
                $('#room_id_create_select').empty();
                $.ajax({
                    url: '{{ route("admin.fetchRooms") }}',
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                        $.each(data.data, function(key, value) {   
                            console.log(key,value)
                            $('#room_id_create_select')
                                .append($("<option></option>")
                                            .attr("value", value.id)
                                            .text(value.label)); 
                        });

                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });

            $(document).on('submit','.create-form',function(e){
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: $(this).data('route'),
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#reference_create_input').val('');
                        $('#brand_create_input').val('');
                        $('#purchaseDate_create_input').val('');
                        $('#price_create_input').val('');
                        $('#room_id_create_select').val('');
                        $('#create-machine').modal('hide');
                        toast.fire({
                            animation: true,
                            title: 'Machine Successfully Created'
                        });
                        $('#machines').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });

            $(document).on('submit','.edit-form',function(e){
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: `machines/${$('.edit-form').data('id')}`,
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#reference_edit_input').val('');
                        $('#brand_edit_input').val('');
                        $('#purchaseDate_edit_input').val('');
                        $('#price_edit_input').val('');
                        $('#room_id_edit_select').val('');
                        $('#edit-machine').modal('hide');
                        toast.fire({
                            animation: true,
                            title: 'Machine Successfully Edited'
                        });
                        $('#machines').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });



    </script>

@stop


