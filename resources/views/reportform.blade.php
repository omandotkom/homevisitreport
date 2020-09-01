@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Tambah Laporan</h1>
@stop

@section('content')
<div class="card w-50 mx-auto">
    <h5 class="card-header">Formulir Laporan Home Visit</h5>
    <div class="card-body">

        <form id="form-laporan" class="w-100" @if(isset($visit)) action="{{route('update-laporan',$visit->id)}}" @else action="{{route('store-laporan')}}" @endif enctype="multipart/form-data" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama">Nama Pemerlu Perjalanan</label>
                <input required type="text" class="form-control" id="nama" name="nama" @if(isset($visit)) value="{{$visit->nama}}" @endif placeholder="Suwandi">
            </div>
            <div class="form-group">
                <label for="namakegiatan">Nama Kegiatan</label>
                <input required type="text" class="form-control" id="namakegiatan" @if(isset($visit)) value="{{$visit->namakegiatan}}" @endif name="namakegiatan" placeholder="Berjunjung ke rumah X">
            </div>
            <div class="form-group">
                <label for="tujuan">Tujuan</label>
                <textarea required class="form-control" id="tujuan" name="tujuan" rows="3">@if(isset($visit)){{$visit->tujuan}}@endif</textarea>
            </div>

            <div class="form-group">
                <label for="tanggal">Hari & Tanggal</label>
                <input required type="date" class="form-control" id="tanggal" @if(isset($visit)) value="{{$visit->tanggal}}" @endif name="tanggal">
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
                <textarea class="form-control" name="hasil" id="hasil" rows="3">@if(isset($visit)){{$visit->hasil}}@endif</textarea>
            </div>
            <div class="form-group">
                <label for="Foto">Foto Kegiatan</label>
                @if(isset($visit->foto))
                <img src="{{$visit->foto}}"  class="rounded img-fluid mb-2 w-25 mx-auto d-block" alt="foto kegiatan">
                @endif
                <input type="file" class="form-control-file mx-auto d-block" name="foto" id="foto">
            </div>
            @if(isset($visit) && $edit)
            <div class="form-group">
                <label for="nosurat">Nomor Surat</label>
                <input required type="text" class="form-control" id="nosurat" @if(isset($visit)) value="{{$visit->nosurat}}" @endif name="nosurat">
            </div>
            <div class="form-group">
                <label for="dipa">DIPa</label>
                <input required type="text" class="form-control" id="dipa" @if(isset($visit)) value="{{$visit->dipa}}" @endif name="dipa">
            </div>
            @endif
            <hr>
            </hr>
            <div class="btn-group float-right" role="group" aria-label="Action Button">
                @if(isset($visit))
                <button type="button" class="btn btn-dark float-right mr-2" id="print" ><i class="fas fa-print"></i> Print</button>
                @endif
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
    
    $("#print").click(function(){
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