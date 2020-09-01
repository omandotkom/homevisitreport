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
    <dl class="mt-2 ml-3">
      <dt>A. Nama Pemerlu Perjalanan</dt>
      <dd>{{$visit->nama}}</dd>
      <dt>B. Tujuan</dt>
      <dd>{{$visit->tujuan}}</dd>
      <dt>C. Tanggal</dt>
      <dd>{{$visit->tanggal}}</dd>
      <dt>D. Tempat</dt>
      <dd>{{$visit->tempat}}</dd>
      <dt>E. Petugas Pelaksana</dt>
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
    </dl>
  </div>


</body>

</html>