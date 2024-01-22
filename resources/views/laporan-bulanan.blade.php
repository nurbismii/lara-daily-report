<!DOCTYPE html>
<html lang="en">

<head>
  <!-- <meta charset="utf-8" /> -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Laporan Bulanan</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    /* Thick red border */
    hr.new4 {
      border: 0.2px solid black;
    }

    .justify {
      text-align: justify;
    }

    .table-line {
      width: 100%;
      border-collapse: collapse;
    }

    .table-line th {
      background: #85CB90;
      color: #FFFFFF;
      padding: 0.3em;
      text-align: left;
    }

    .table-line td {
      border-bottom: 1px solid #DDDDDD;
      color: #666666;
      padding: 0.5em;
    }
  </style>
</head>

<body class="nav-fixed">
  <div id="layoutSidenav">
    <main>
      <!-- Main page content-->
      <div class="container-xl px-1">
        @php

        $no = 1;

        @endphp

        @foreach($datas as $jenis_kegiatan => $data)
        <div class="d-flex justify-content-between">
          <h6>{{ $sub_no = $no++ }}. {{ getJenisKegiatanById($jenis_kegiatan) }}</h6>
        </div>
        @foreach($data as $key => $d)
        <div class="px-4">
          <div class="d-flex justify-content-between">
            {{ $sub_no }}.{{ ++$key }} {{ $d->kegiatan }}
          </div>
          <div class="d-flex justify-content-between mb-3" style="text-indent: 32px;">
            {{ $d->uraian_kegiatan }}
          </div>
          @if($d->kuantitas > 0)
          <div class="d-flex justify-content-between mb-3">
            Kuantitas : {{ $d->kuantitas }}
          </div>
          @endif
          <div class="d-flex justify-content-between">
            Kendala :
          </div>
          <div class="d-flex justify-content-between mb-3" style="text-indent: 32px;">
            {{ $d->kendala ?? 'Tidak ada kendala' }}
          </div>
          <div class="d-flex justify-content-between mb-3">
            Persentase penyelesaian : {{ $d->persen == NULL ? 0 : $d->persen }}%
          </div>

          @if(count($d->dataPendukung) > 0)
          <div class="d-flex justify-content-between mb-3">
            Data Pendukung :
          </div>
          <div class="d-flex justify-content-between mb-3">
            @foreach($d->dataPendukung as $value)
            <img src="{{ asset('data-pendukung/' . $d->nik . '/' . $d->kegiatan . '/' . $value->nama_file) }}" width="650" height="400">
            @endforeach
          </div>
          @endif
        </div>
        @endforeach

        @endforeach
    </main>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
</body>

</html>