@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <h4 class="fw-bold py-2 mb-2">Kegiatan harian</h4>
    <!-- Basic Bootstrap Table -->
    <div class="col-lg-12">
      @include('message')
    </div>
    <div class="col-xl-12">
      <div class="card mb-3">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <select name="nama_tim" id="nama_tim" class="form-select">
                <option value="" selected>-- Filter Tim --</option>
                @foreach($list_tim as $lt)
                <option value="{{ $lt->nama_tim }}">{{ $lt->nama_tim }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <div class="input-group">
                <input type="text" name="daterange" class="form-control filter">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="card">
        <h5 class="card-header">Tabel kegiatan</h5>
        <div class="table-responsive text-nowrap">
          <table class="table table-hover" id="tabel-kegiatan">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Tim</th>
                <th>Tanggal</th>
                <th>Masuk</th>
                <th>istirahat</th>
                <th>Kembali</th>
                <th>Pulang</th>
                <th>Status SPV</th>
                <th>Status Asmen</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $('input[name="daterange"]').daterangepicker({
      startDate: moment().subtract(1, 'M'),
      endDate: moment()
    });

    var table = $('#tabel-kegiatan').DataTable({
      processing: true,
      serverSide: true,
      searching: true,
      responsive: true,
      ajax: {
        url: "/kegiatan-harian",
        data: function(d) {
          d.search = $('input[type="search"]').val();
          d.nama_tim = $('#nama_tim').val();
          d.from_date = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
          d.to_date = $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
        }
      },
      columns: [{
          data: 'name',
          name: 'name'
        },
        {
          data: 'nama_tim',
          name: 'nama_tim',
        },
        {
          data: 'tanggal',
          name: 'tanggal'
        },
        {
          data: 'jam_masuk',
          name: 'jam_masuk'
        },
        {
          data: 'jam_istirahat',
          name: 'jam_istirahat'
        },
        {
          data: 'jam_kembali_istirahat',
          name: 'jam_kembali_istirahat'
        },
        {
          data: 'jam_pulang',
          name: 'jam_pulang'
        },
        {
          data: 'status_spv',
          name: 'status_spv',
          render: function(data, type, row) {
            badge = '';
            switch (data) {
              case 'Diterima':
                badge = '<span class="badge bg-success">' + data + '</span>';
                break;
              case null:
                badge = '<span class="badge bg-primary">' + 'Menunggu' + '</span>';
                break;
            }
            return badge;
          }
        },
        {
          data: 'status_asmen',
          name: 'status_asmen',
          render: function(data, type, row) {
            badge = '';
            switch (data) {
              case 'Diterima':
                badge = '<span class="badge bg-success">' + data + '</span>';
                break;
              case null:
                badge = '<span class="badge bg-primary">' + 'Menunggu' + '</span>';
                break;
            }
            return badge;
          }
        },
        {
          data: 'aksi',
          name: 'aksi',
          orderable: false
        },
      ],
      order: [
        [2, 'desc']
      ]
    });

    $(".filter").change(function() {
      table.draw();
    });

    $('#nama_tim').change(function() {
      table.draw();
    });

  });
</script>

@endsection