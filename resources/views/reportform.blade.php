@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Tambah Laporan</h1>
@stop

@section('content')
<div class="card w-50 mx-auto">
    <h5 class="card-header">Formulir Laporan Kegiatan</h5>
    <div class="card-body">

        <form id="form-laporan" class="w-100" @if(isset($visit)) action="{{route('update-laporan',$visit->id)}}" @else action="{{route('store-laporan')}}" @endif enctype="multipart/form-data" method="POST">
            @csrf
            {{--<div class="form-group">
                <label for="nama">Nama Pemerlu Perjalanan</label>
                <input required type="text" class="form-control" id="nama" name="nama" @if(isset($visit)) value="{{$visit->nama}}" @endif placeholder="Suwandi">
    </div>--}}
    <div class="form-group">
        <label for="namakegiatan">Nama Kegiatan</label>
        <input required type="text" class="form-control" id="namakegiatan" @if(isset($visit)) value="{{$visit->namakegiatan}}" @endif name="namakegiatan" placeholder="Berkunjung ke ...">
    </div>
    <div class="form-group">
        <label for="tujuan">Tujuan</label>
        <textarea required class="form-control" id="tujuan" name="tujuan" rows="6">@if(isset($visit)){{$visit->tujuan}}@endif</textarea>
    </div>
    <div class="form-group">
        <label for="dasar">Dasar Kegiatan</label>
        <textarea required class="form-control" id="dasar" name="dasar" rows="6">@if(isset($visit)){{$visit->dasar}}@endif</textarea>
    </div>

    <div class="form-group">
        <label for="tanggal">Hari & Tanggal (Dari)</label>
        <input required type="date" class="form-control" id="tanggal" @if(isset($visit)) value="{{$visit->tanggal}}" @endif name="tanggal">
        @if(isset($visit))
        <small>{{Carbon\Carbon::parse($visit->tanggal)->translatedFormat('l, d F Y')}}</small>
        @endif
    </div>
    <div class="form-group">
        <label for="tanggalend">Hari & Tanggal (Sampai)</label>
        <input required type="date" class="form-control" id="tanggalend" @if(isset($visit)) value="{{$visit->tanggalend}}" @endif name="tanggalend">
        @if(isset($visit))
        <small>{{Carbon\Carbon::parse($visit->tanggalend)->translatedFormat('l, d F Y')}}</small>
        @endif
    </div>
    <div class="form-group">
        <label>Petugas Pelaksana</label>

        <table class="table table-bordered" id="dynamicTable">
            <tr>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jabatan</th>
            </tr>
            @if(!isset($visit))

            <tr>
                <td><input required type="text" name="addmore[0][nama]" placeholder="Iswanto" class="form-control" /></td>
                <td><input required type="text" name="addmore[0][nip]" placeholder="7847283" class="form-control" /></td>
                <td><input required type="text" name="addmore[0][jabatan]" placeholder="Staff Operasional" class="form-control" /></td>
                <td><button type="button" name="add" id="add" class="btn btn-success"><i class="fas fa-plus-circle"></i></button></td>
            </tr>
            <tr>
                <td><input required type="text" name="addmore[1][nama]" placeholder="Iswanto" class="form-control" /></td>
                <td><input required type="text" name="addmore[1][nip]" placeholder="7847283" class="form-control" /></td>
                <td><input required type="text" name="addmore[1][jabatan]" placeholder="Staff Operasional" class="form-control" /></td>
                <td><button type="button" class="btn btn-danger remove-tr"><i class="fas fa-minus-circle"></i></button></td>
            </tr>
            <tr>
                <td><input required type="text" name="addmore[2][nama]" placeholder="Iswanto" class="form-control" /></td>
                <td><input required type="text" name="addmore[2][nip]" placeholder="7847283" class="form-control" /></td>
                <td><input required type="text" name="addmore[2][jabatan]" placeholder="Staff Operasional" class="form-control" /></td>
                <td><button type="button" class="btn btn-danger remove-tr"><i class="fas fa-minus-circle"></i></button></td>
            </tr>
            <tr>
                <td><input required type="text" name="addmore[3][nama]" placeholder="Iswanto" class="form-control" /></td>
                <td><input required type="text" name="addmore[3][nip]" placeholder="7847283" class="form-control" /></td>
                <td><input required type="text" name="addmore[3][jabatan]" placeholder="Staff Operasional" class="form-control" /></td>
                <td><button type="button" class="btn btn-danger remove-tr"><i class="fas fa-minus-circle"></i></button></td>
            </tr>
            @else
            @php $indexOfficer = 0; @endphp
            @foreach($visit->officers as $officer)
            <tr>
                <td><input required type="text" value="{{$officer->nama}}" name="addmore[{{$indexOfficer}}][nama]" placeholder="Iswanto" class="form-control" /></td>
                <td><input required type="text" value="{{$officer->nip}}" name="addmore[{{$indexOfficer}}][nip]" placeholder="7847283" class="form-control" /></td>
                <td><input required type="text" value="{{$officer->jabatan}}" name="addmore[{{$indexOfficer}}][jabatan]" placeholder="Staff Operasional" class="form-control" /></td>
                @if($loop->first)
                <td><button type="button" name="add" id="add" class="btn btn-success"><i class="fas fa-plus-circle"></i></button></td>

                @else
                <td><button type="button" class="btn btn-danger remove-tr"><i class="fas fa-minus-circle"></i></button></td>
                @endif
            </tr>
            @php $indexOfficer++; @endphp
            @endforeach
            @endif
        </table>
    </div>
    <div class="form-group">
        <label for="tempat">Tempat</label>
        <input required type="text" class="form-control" id="tempat" @if(isset($visit)) value="{{$visit->tempat}}" @endif name="tempat">
    </div>
    <div class="form-group">
        <label for="hasil">Hasil Kegiatan</label>
        <textarea class="form-control" name="hasil" id="hasil" rows="6">@if(isset($visit)){{$visit->hasil}}@endif</textarea>
    </div>
    <div class="form-group">
        <label for="Foto">Foto Kegiatan 1</label>
        @if(isset($visit->foto))
        <img src="{{asset($visit->foto)}}" class="rounded img-fluid mb-2 w-25 mx-auto d-block" alt="foto kegiatan">
        @endif
        <input type="file" class="form-control-file mx-auto d-block" name="foto" id="foto">
        <label for="Foto">Foto Kegiatan 2</label>
        @if(isset($visit->foto2))
        <img src="{{asset($visit->foto2)}}" class="rounded img-fluid mb-2 w-25 mx-auto d-block" alt="foto kegiatan">
        @endif
        <input type="file" class="form-control-file mx-auto d-block" name="foto2" id="foto">

    </div>
    {{--@if(isset($visit) && $edit)
            <div class="form-group">
                <label for="nosurat">Nomor Surat</label>
                <input required type="text" class="form-control" id="nosurat" @if(isset($visit)) value="{{$visit->nosurat}}" @endif name="nosurat">
</div>
<div class="form-group">
    <label for="dipa">DIPa</label>
    <input required type="text" class="form-control" id="dipa" @if(isset($visit)) value="{{$visit->dipa}}" @endif name="dipa">
</div>
@endif--}}
<div class="form-group">
    <label for="penutup">Penutup</label>
    <textarea class="form-control" required name="penutup" id="penutup" rows="6">@if(isset($visit)){{$visit->penutup}}@endif</textarea>
</div>
<hr>
</hr>
<div class="form-group">
    <h5>Mengetahui</h5>
    <label for="mengetahuinama">Nama</label>
    <input required type="text" class="form-control" id="mengetahuinama" @if(isset($visit)) value="{{$visit->knows->nama}}" @endif name="mengetahuinama">
</div>
<div class="form-group">
    <label for="mengetahuijabatan">Jabatan</label>
    <input required type="text" class="form-control" id="mengetahuijabatan" @if(isset($visit)) value="{{$visit->knows->jabatan}}" @endif name="mengetahuijabatan">
</div>
<hr>
</hr>
<div class="form-group">
    <h5>Yang Melaporkan</h5>
    <label for="melaporkannama">Nama</label>
    <input required type="text" class="form-control" id="melaporkannama" @if(isset($visit)) value="{{$visit->reporters->nama}}" @endif name="melaporkannama">
</div>
<div class="form-group">
    <label for="melaporkanjabatan">Jabatan</label>
    <input required type="text" class="form-control" id="melaporkanjabatan" @if(isset($visit)) value="{{$visit->reporters->jabatan}}" @endif name="melaporkanjabatan">
</div>
<hr>
</hr>
<div class="btn-group float-right" role="group" aria-label="Action Button">
    <button type="submit" class="btn btn-dark float-right"><i class="far fa-save"></i> Simpan</button>
</div>
</form>
</div>
</div>
@stop

@section('css')

@stop

@section('js')
<script type="text/javascript">
    //nanti in dicek

    @if(isset($visit))

    $("#print").click(function() {
        let actionURL = "{{route('print',$visit->id)}}";
        document.getElementById("form-laporan").action = actionURL;
        document.getElementById("form-laporan").submit();

    });
    @endif
    $("#add").click(function() {
        var i = document.getElementById("dynamicTable").rows.length;
        if (i >= 2) {
            i = i - 2;
        }
        ++i;
        $("#dynamicTable").append('<tr><td><input type="text" name="addmore[' + i + '][nama]" placeholder="Agustinus" class="form-control" /></td><td><input type="text" name="addmore[' + i + '][nip]" placeholder="9049129" class="form-control" /></td><td><input type="text" name="addmore[' + i + '][jabatan]" placeholder="Staff Keuangan" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr"><i class="fas fa-minus-circle"></i></button></td></tr>');
    });
    $(document).on('click', '.remove-tr', function() {
        $(this).parents('tr').remove();
    });
</script>
@stop