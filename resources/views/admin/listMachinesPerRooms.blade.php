@extends('adminlte::page')

@section('title', 'Gestion des utilisateurs')

@section('content_header')
    <h1>List Machines Par Salles</h1>
@stop


@section('content')
    <div class="card">
        <div class="card-body">
            <div class="mx-2 mb-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="room_id" class="form-label">Selectionez une Salle</label>
                        <select class="form-control" id="listMachines"></select>                                  
                    </div>
                </div>
            </div>
            
            <table id="machines" class="table table-hover table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Référence</th>
                        <th>Marque</th>
                        <th>Date d'achat</th>
                        <th>Prix (DH)</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@stop


@section('js')
    <script>
        $(document).ready(function() {
            var machines_table = $('#machines').DataTable({
                columns: [
                    {data: 'id'},
                    {data: 'reference'},
                    {data: 'brand'},
                    {data: 'purchaseDate'},
                    {data: 'price'},
                ],
            });

            $.ajax({
                url: '{{ route("admin.fetchRooms") }}',
                type: 'GET',
                success: function(data) {
                    $("<option></option>")
                    .text("Selectionez une Salle")
                    .appendTo('#listMachines');
                    
                    $('#listMachines').empty();

                    $.each(data.data, function(key, value) {   
                        $("<option></option>")
                        .attr("value", value.id)
                        .text(value.label)
                        .appendTo('#listMachines');
                    });

                    $.ajax({
                        url: `/admin/fetchMachinesPerRooms/${data.data[0].id}`,
                        success: function(data) {
                            machines_table.clear();
                            machines_table.rows.add(data.data).draw();
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });

            $(document).on('change','#listMachines', function(e) {
                var room_id = $(this).val();
                $(`#listMachines option[value=${room_id}]`).prop('selected', true);

                if(room_id){
                    $.ajax({
                        url: `/admin/fetchMachinesPerRooms/${room_id}`,
                        success: function(data) {
                            // console.log(data);
                            machines_table.clear();
                            machines_table.rows.add(data.data).draw();
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                }
                else{
                    machines_table.clear();
                }
            });
        });
    </script>

@stop