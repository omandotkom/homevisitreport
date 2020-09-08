@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')

<div class="card text-center align-bottom mx-auto my-auto w-50 d-flex h-100 shadow-lg">
    {{--<div class="card-header">
        Laporan 
    </div>--}}
    <div class="card-body">
        <div class="d-flex align-items-end flex-column bd-highlight mb-3" >
            <div class="p-2 bd-highlight"><a href="{{route('list-laporan')}}" class="badge badge-pill badge-success"><i class="fas fa-table"></i> Lihat Data</a></div>
        </div>
        <hr>
        </hr>
        <h3 class="card-text m-5"><strong>Laporan Kegiatan BRSKPN Satria Baturaden<strong></h3>
        <hr>
        </hr>
        <a href="{{route('index-laporan')}}" class="btn btn-dark"><i class="fas fa-chevron-circle-right"></i> Selanjutnya</a>
    </div>
    <div class="card-footer text-muted">
        <label id="date-part"></label> <label id="time-part"></label>
    </div>
</div>
@stop

@section('css')
{{--<link rel="stylesheet" href="/css/admin_custom.css">--}}
@stop

@section('js')
<script>
    $(document).ready(function() {
        var interval = setInterval(function() {
            var momentNow = moment();
            $('#date-part').html(momentNow.format('YYYY MMMM DD') + ' ' +
                momentNow.format('dddd')
                .substring(0, 3).toUpperCase());
            $('#time-part').html(momentNow.format('A hh:mm:ss'));
        }, 100);

    });
</script>
@stop