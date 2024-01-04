@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-2 mb-2">Data Pelayanan</h4>
  <div class="row">
    <!-- Basic Bootstrap Table -->
    <div class="col-lg-12">
      @include('message')
    </div>
    <div class="col-xl-12">
      <div class="card mb-3">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" name="daterange" value="" />
            </div>
            <div class="col-md-6">
              <button class="btn btn-success filter">Filter</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="card">
        <h5 class="card-header">Tabel pelayanan</h5>
        <div class="table-responsive text-nowrap">
          <table class="table" id="tabel-pelayanan">
            <thead>
              <tr>
                <th>PIC</th>
                <th>Nama Karyawan</th>
                <th>NIK</th>
                <th>Posisi</th>
                <th>Kategori</th>
                <th>Sub kategori</th>
                <th>Tanggal</th>
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

    var table = $('#tabel-pelayanan').DataTable({
      processing: true,
      serverSide: true,
      searching: true,
      responsive: true,
      ajax: {
        url: "/pelayanan/hr",
        data: function(d) {
          d.search = $('input[type="search"]').val()
          d.from_date = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
          d.to_date = $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
        }
      },
      columns: [{
          data: 'name',
          name: 'name'
        },
        {
          data: 'nama_karyawan',
          name: 'nama_karyawan'
        },
        {
          data: 'nik_karyawan',
          name: 'nik_karyawan'
        },
        {
          data: 'posisi',
          name: 'posisi'
        },
        {
          data: 'kategori_pelayanan',
          name: 'kategori_pelayanan',
          render: function(data, type, row) {
            badge = '';
            if (data != null) {
              badge = '<span class="badge bg-success">' + data + '</span>';
            }
            if (data == null) {
              badge = '<span class="badge bg-primary">' + 'Tanpa kategori' + '</span>';
            }
            return badge;
          }
        },
        {
          data: 'sub_kategori_pelayanan',
          name: 'sub_kategori_pelayanan',
          render: function(data, type, row) {
            badge = '';
            if (data != null) {
              badge = '<span class="badge bg-primary">' + data + '</span>';
            }
            if (data == null) {
              badge = '<span class="badge bg-warning">' + 'Tanpa sub' + '</span>';
            }
            return badge;
          }
        },
        {
          data: 'tanggal',
          name: 'tanggal'
        },
        {
          data: 'aksi',
          name: 'aksi',
          orderable: false
        },
      ],
      order: [
        [6, 'desc']
      ]
    });

    $(".filter").click(function() {
      table.draw();
    });

  });
</script>

@endsection