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
  </style>
</head>

<body class="nav-fixed">
  <div id="layoutSidenav">
    <main>
      <!-- Main page content-->
      <div class="container-xl px-1">
        <div class="text-center">
          <h2 class="fw-bold">LAPORAN BULANAN</h2>
        </div>
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
          <div class="d-flex justify-content-between">
            Kendala :
          </div>
          <div class="d-flex justify-content-between mb-3" style="text-indent: 32px;">
            {{ $d->kendala }}
          </div>
          <div class="d-flex justify-content-between mb-3">
            Persentase penyelesaian : {{ $d->persen == NULL ? 0 : $d->persen }}%
          </div>
          <div class="d-flex justify-content-between">
            Data Pendukung :
          </div>
          <div class="d-flex justify-content-between mb-3">
            @foreach($d->dataPendukung as $value)
            <img src="{{ asset('data-pendukung/' . $d->nik . '/' . $d->kegiatan . '/' . $value->nama_file) }}" alt="Data Pendukung" width="300" height="300">
            @endforeach
          </div>
        </div>
        @endforeach
        @endforeach
    </main>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
</body>

</html>