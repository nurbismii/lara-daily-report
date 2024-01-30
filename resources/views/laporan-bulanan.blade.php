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
    #pelayanan {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #pelayanan td,
    #pelayanan th {
      border: 1px solid #ddd;
      padding: 3px;
    }

    #pelayanan tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    #pelayanan tr:hover {
      background-color: #ddd;
    }

    #pelayanan th {
      padding-top: 5px;
      padding-bottom: 5px;
      text-align: left;
      background-color: #252866;
      color: white;
    }

    #kuantitas {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #kuantitas td,
    #kuantitas th {
      border: 1px solid #ddd;
      padding: 3px;
    }

    #kuantitas tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    #kuantitas tr:hover {
      background-color: #ddd;
    }

    #kuantitas th {
      padding-top: 5px;
      padding-bottom: 5px;
      text-align: left;
      background-color: #04AA6D;
      color: white;
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
        $no_pelayanan = 1;
        @endphp

        @foreach($datas as $jenis_kegiatan => $data)
        <div class="d-flex justify-content-between">
          <h6>{{ $sub_no = $no++ }}. {{ getJenisKegiatanById($jenis_kegiatan) }}</h6>
        </div>

        @foreach($data as $key => $d)

        <div class="px-4">
          <div class="d-flex justify-content-between">
            {{ $sub_no }}.{{ ++$key }} {{ ucfirst(strtolower($d['kegiatan'])) }}
          </div>
          <div class="d-flex justify-content-between mb-3" style="text-indent: 32px;">
            {{ ucfirst($d['uraian_kegiatan']) }}
          </div>
          @if(count($d['data_pelayanan']) > 0)
          <div class="d-flex justify-content-between mb-3">
            <table id="pelayanan">
              <tr>
                <th style="text-align: center;" colspan="3">DATA PELAYANAN</th>
              </tr>
              <tr>
                <th>No</th>
                <th>Pelayanan</th>
                <th>Total</th>
              </tr>
              @foreach($d['data_pelayanan'] as $value)
              @if( $value['id_pelayanan'] == $d['id'])
              <tr>
                <td>{{ $no_pelayanan++ }}</td>
                <td>{{ $value['kategori_pelayanan'] ?? '' }}</td>
                <td>{{ $value['total_pelayanan'] ?? '' }}</td>
              </tr>
              @endif
              @endforeach
            </table>
          </div>
          @endif

          @if($d['kuantitas'] > 0)
          <div class="d-flex justify-content-between mb-3">
            <table id="kuantitas">
              <tr>
                <th style="text-align: center;" colspan="3">TOTAL KUANTITAS KEGIATAN</th>
              </tr>
              <tr>
                <th>Kegiatan</th>
                <th>Total</th>
                <th>Satuan</th>
              </tr>
              <tr>
                <td>{{ ucfirst(strtolower($d['kegiatan'])) }}</td>
                <td>{{ $d['kuantitas'] }}</td>
                <td>-</td>
              </tr>
            </table>
          </div>
          @endif

          <div class="d-flex justify-content-between">
            Kendala :
          </div>
          <div class="d-flex justify-content-between mb-3" style="text-indent: 32px;">
            {{ $d['kendala'] ?? 'Tidak ada kendala' }}
          </div>
          <div class="d-flex justify-content-between mb-3">
            Persentase penyelesaian : {{ $d['persen'] == NULL ? 0 : $d['persen'] }}%
          </div>

          @if(count($d['data_pendukung']) > 0)
          <div class="d-flex justify-content-between mb-3">
            Data Pendukung :
          </div>
          <div class="d-flex justify-content-between mb-3">
            @foreach($d['data_pendukung'] as $value)
            <img src="{{ public_path('data-pendukung/' . $d['nik'] . '/' . $d['kegiatan'] . '/' . $value['nama_file']) }}" width="650" height="400">
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