<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Document</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="bd-example">
    <h5 class="text-center">LAPORAN KEGIATAN HOME VISIT<br>PEMERLU PELAYANAN KESEJAHTERAAN SOSIAL<br>BRSKPN "SATRIA" DI BATURRADEN</h5><br>
    <hr>
    </hr>
    <dl class="mt-2 ml-4 mr-4">
      <dt>A. Nama Kegiatan</dt>
      <dd>{{$visit->namakegiatan}}</dd>
      <dt>B. Nama Pemerlu Pelayanan</dt>
      <dd>{{$visit->nama}}</dd>
      <dt>C. Tujuan</dt>
      <dd>{{$visit->tujuan}}</dd>
      <dt>D. Dasar Kegiatan</dt>
      <dd>Surat Tugas Nomor {{$visit->nomorsurat}} tentang pelaksanaan Kegiatan Home Visit Pemerlu Pelayanan Kesejahteraan Sosial atas nama {{$visit->nama}} Daftar Isian Pelaksanaan Anggaran (DIPA) BRSKP NAPZA "Satria" di Baturraden No : {{$visit->dipa}}</dd>
      <dt>E. Waktu & Tempat</dt>
      <dd>Adapun kegiatan ini akan dilaksanakan pada :</dd>
      <table class="table table-responsive-sm table-sm text-left table-borderless">

        <tr>
          <th style="width:1px">Waktu</th>
          <td style="width:1px">:</td>
          <td style="width:1px">{{$visit->tanggal}}</td>
        </tr>
        <tr>
          <th style="width:1px">Tempat</th>
          <td style="width:1px">:</td>
          <td style="width:1px">{{$visit->tempat}}</td>
        </tr>
      </table>
      
      <dt>F. Petugas Pelaksana</dt>
      <table class="table table-responsive-sm table-sm text-left table-borderless">

        @foreach($visit->officers as $o)
        <tr>
          <th style="width:5px">{{$loop->index+1}}.</th>
          <th style="width:5px">Name</th>
          <td style="width:5px">:</td>
          <td>{{$o->nama}}</td>
        </tr>
        <tr>
          <td></td>
          <th>NIP</th>
          <td>:</td>
          <td>{{$o->nip}}</td>
        </tr>
        <tr>
          <td></td>
          <th>Jabatan</th>
          <td>:</td>
          <td>{{$o->jabatan}}</td>
        </tr>
        @endforeach
      </table>
      <dt>G. Hasil</dt>
      <dd>{{$visit->hasil}}</dd>
      <dt>H. Penutup</dt>
      <dd>Demikian laporan Kegiatan Home Visit Pemerlu Pelayanan Kesejahteraan Sosial ataas nama {{$visit->nama}} ini dibuat sebagai bahan pertanggungjawaban kegiatan dan dapat digunakan sebagaiana mestinya.</dd>
      <table class="table mt-5 p-0 w-100 table-responsive-sm table-sm table-borderless">
  <thead> 
  <tbody>
    <tr>
      <td class="w-25"></td>
      <td class="w-25"></td>
      <td class="w-auto">Dibuat</td>
      <td class="w-auto">: Baturraden</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td>Pada Tanggal</td>
      <td>: {{date("m.d.Y")}}</td>
    </tr>
    <tr>
      <td colspan="2" class="text-center mt-3">Mengetahui<br>Kepala Seksi Layanan Rehabilitasi Sosial</td>
      <td colspan="2" class="text-center align-middle">Yang Melaporkan</td>
    </tr>
    <tr>
      <td colspan="2" class="text-center align-text-bottom"><br><br><br>Hendra Permana, S.Sos M.Si</td>
      <td colspan="2" class="text-center align-text-bottom"><br><br><br>.......</td>
    </tr>
  </tbody>
</table>
    </dl>
    
  </div>


</body>

</html>