

@section('title', 'Register')

@extends('adminlte::auth.register')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @if (session('message'))
        <script>
            toastr.options = {
                "positionClass": "toast-top-center", 
            }
            $(function () {
                toastr.success('{{ session('message') }}');
            });
        </script>
    @endif
@stop