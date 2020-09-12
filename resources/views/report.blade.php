@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Daftar Kunjungan</h1>
@stop

@section('content')
<div class="card w-75 mx-auto">
    <h5 class="card-header">Daftar Data Lapoan</h5>
    <div class="card-body">
        <table class="table table-responsive-md">
            <thead>
                <tr>
                    <th scope="col">Kegiatan</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Terakhir Diubah</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($visits as $visit)
                <tr><td>{{$visit->namakegiatan}}</td>
                    <td>{{Carbon\Carbon::parse($visit->tanggal)->translatedFormat('l, d F Y')}}<br>Sampai<br>{{Carbon\Carbon::parse($visit->tanggalend)->translatedFormat('l, d F Y')}}</td>
                    <td>{{Carbon\Carbon::parse($visit->updated_at)->translatedFormat('l, d F Y')}}</td>
                    <td><a href="{{route('edit-laporan',['id'=>$visit->id])}}" class="badge badge-success"><i class="fas fa-plus-circle"></i></a><a href="{{route('printreport',['id'=>$visit->id])}}" class="badge badge-success m-1"><i class="fas fa-print"></i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

@stop