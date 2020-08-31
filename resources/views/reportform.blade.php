@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Tambah Laporan</h1>
@stop

@section('content')
<div class="card w-50 mx-auto">
    <h5 class="card-header">Formulir Laporan Home Visit</h5>
    <div class="card-body">

        <form class="w-100" action="{{route('store-laporan')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama">Nama Pemerlu Perjalanan</label>
                <input required type="text" class="form-control" id="nama" name="nama" placeholder="Suwandi">
            </div>
            <div class="form-group">
                <label for="namakegiatan">Nama Kegiatan</label>
                <input required type="text" class="form-control" id="namakegiatan" name="namakegiatan" placeholder="Berjunjung ke rumah X">
            </div>
            <div class="form-group">
                <label for="tujuan">Tujuan</label>
                <textarea  required class="form-control" id="tujuan" name="tujuan" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="tanggal">Hari & Tanggal</label>
                <input required type="date" class="form-control" id="tanggal" name="tanggal">
            </div>
            <div class="form-group">
                <label>Petugas Pelaksana</label>
                <table class="table table-bordered" id="dynamicTable">
                    <tr>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Jabatan</th>
                    </tr>
                    <tr>
                        <td><input required type="text" name="addmore[0][nama]" placeholder="Iswanto" class="form-control" /></td>

                        <td><input required type="text" name="addmore[0][nip]" placeholder="7847283" class="form-control" /></td>

                        <td><input required type="text" name="addmore[0][jabatan]" placeholder="Staff Operasional" class="form-control" /></td>

                        <td><button type="button" name="add" id="add" class="btn btn-success"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </table>
            </div>
            <div class="form-group">
                <label for="tempat">Tempat</label>
                <input required type="text" class="form-control" id="tempat" name="tempat">
            </div>
            <div class="form-group">
                <label for="hasil">Hasil Kegiatan</label>
                <textarea class="form-control" name="hasil" id="hasil" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="Foto">Foto Kegiatan</label>
                <input type="file" class="form-control-file" id="exampleFormControlFile1">
            </div>
            <hr></hr>
            <button type="submit" class="btn btn-dark float-right"><i class="far fa-save"></i> Simpan</button>
        </form>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script type="text/javascript">
    var i = 0;
    $("#add").click(function() {
        ++i;
        $("#dynamicTable").append('<tr><td><input type="text" name="addmore[' + i + '][nama]" placeholder="Agustinus" class="form-control" /></td><td><input type="text" name="addmore[' + i + '][nip]" placeholder="9049129" class="form-control" /></td><td><input type="text" name="addmore[' + i + '][jabatan]" placeholder="Staff Keuangan" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr"><i class="fas fa-minus-circle"></i> Hapus</button></td></tr>');
    });
    $(document).on('click', '.remove-tr', function() {
        $(this).parents('tr').remove();
    });
</script>
@stop