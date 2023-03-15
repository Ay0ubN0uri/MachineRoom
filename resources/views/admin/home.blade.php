@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Bonjour, {{Auth::user()->name}}</h1>
    <hr>
@stop

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-9">
            <x-adminlte-card class="card_container_custom" title="" theme="info" collapsible removable maximizable>
                <canvas id="nbrMachines"></canvas>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('js')
<script>  
    $(document).ready(function(){
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

        // Initialize overlayScrollbars plugin
        $('body').overlayScrollbars({
            className: 'os-theme-light',
            scrollbars: {
                visibility: 'auto',
                autoHide: 'never'
            },
            callbacks: {
                onInitialized: function() {
                    // Hide spinner on initialization
                    $('.os-spacer').hide();
                },
                onScrollStart: function() {
                    // Show spinner on AJAX request start
                    $('.os-spacer').show();
                },
                onScrollStop: function() {
                    // Hide spinner on AJAX request complete
                    $('.os-spacer').hide();
                }
            }
        });
        $.ajax({
            url: '/admin/statistiques',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var labels = [];
                var values = [];
                var colors = [];
                
                $.each(data, function(key, value) {
                    labels.push(value.label);
                    values.push(value.nbrMachines);
                    colors.push(getRandomColor());
                });
                
                var ctx = document.getElementById('nbrMachines').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Salle',
                            backgroundColor: colors,
                            borderColor: colors,
                            borderWidth: 1,
                            data: values,
                        }]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Nombre des machines par salle'
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        },
                        legend: {
                            display: false,
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                Swal.fire({
                    animation: true,
                    icon: 'error',
                    title: error,
                    text: 'il y a un problème lors de la tentative de récupération des données du serveur',
                })
                $(".card_container_custom").empty()
            }
        });
    })

    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
</script>

@stop