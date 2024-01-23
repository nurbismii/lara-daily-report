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
    #customers {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #customers td,
    #customers th {
      border: 1px solid #ddd;
      padding: 8px;
    }

    #customers tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    #customers tr:hover {
      background-color: #ddd;
    }

    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
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
            Data pelayanan :
          </div>
          <div class="d-flex justify-content-between mb-3">

            <table id="customers">
              <tr>
                <th>No</th>
                <th>Pelayanan</th>
                <th>Total</th>
              </tr>
              @foreach($d['data_pelayanan'] as $value)
              <tr>
                <td>{{ $no_pelayanan++ }}</td>
                <td>{{ $value['kategori_pelayanan'] ?? '' }}</td>
                <td>{{ $value['total_pelayanan'] ?? '' }}</td>
              </tr>
              @endforeach
            </table>
          </div>
          @endif

          @if($d['kuantitas'] > 0)
          <div class="d-flex justify-content-between mb-3">
            Kuantitas : {{ $d['kuantitas'] }}
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