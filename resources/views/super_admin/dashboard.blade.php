@extends('adminlte::page')


@section('content')

    <div class="d-flex justify-content-center my-3">
        <div class="col-md-12">
            <x-adminlte-profile-widget name="{{ Auth::user()->name }}" desc="{{ Auth::user()->email }}" theme="primary"
                img="https://picsum.photos/id/1011/100">
                <x-adminlte-profile-col-item class="text-success border-right" icon="fas fa-lg fa-toggle-on"
                    title="Activé" text="{{$usersActivated}}" size=4 badge="success"/>
                <x-adminlte-profile-col-item class="text-danger" icon="fas fa-lg fa-toggle-off" title="Désactivé"
                    text="{{$usersDeactivated}}" size=4 badge="danger"/>
                <x-adminlte-profile-col-item class="text-info" icon="fas fa-lg fa-users" title="Utilisateurs"
                text="{{$totalUsers}}" size=4 badge="info"/>
            </x-adminlte-profile-widget>
        </div>
    </div>
    
    <x-adminlte-card title="" theme="info"  collapsible removable maximizable>
        <canvas id="myChart"></canvas>
    </x-adminlte-card>
@stop


@section('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Admin activé', 'Admins désactivé', 'Nombre total des admins'],
                datasets: [{
                    label: '',
                    data: [{{$usersActivated}}, {{$usersDeactivated}}, {{$totalUsers}}],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    display: false
                },
            }
        });

    </script>
@stop



