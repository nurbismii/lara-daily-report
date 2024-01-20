@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-2 mb-2">Kegiatan mingguan</h4>
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
        <h5 class="card-header">Tabel mingguan
          <a href="/kegiatan-mingguan/create" class="text-white btn btn-primary btn-sm float-end">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Kegiatan mingguan
          </a>
        </h5>
        <div class="table-responsive text-nowrap">
          <table class="table table-hover" id="tabel-kegiatan-mingguan">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Jenis kegiatan</th>
                <th>Kategori kegiatan</th>
                <th>Persentase</th>
                <th>Deadline</th>
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

    var table = $('#tabel-kegiatan-mingguan').DataTable({
      processing: true,
      serverSide: true,
      searching: true,
      responsive: true,
      ajax: {
        url: "/kegiatan-mingguan",
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
          data: 'tanggal',
          name: 'tanggal'
        },
        {
          data: 'jenis_kegiatan',
          name: 'jenis_kegiatan'
        },
        {
          data: 'kategori_kegiatan',
          name: 'kategori_kegiatan'
        },
        {
          data: 'persen',
          name: 'persen',
          render: function(data, type, row) {
            badge = '';
            if (data == null) {
              badge = '<span class="badge bg-primary">' + '0%' + '</span>';
            } else if (data != null) {
              badge = '<span class="badge bg-primary">' + data + '%' + '</span>';
            }

            return badge;
          }
        },
        {
          data: 'deadline',
          name: 'deadline'
        },
        {
          data: 'aksi',
          name: 'aksi',
          orderable: false
        },
      ],
      order: [
        [1, 'desc']
      ]
    });

    $(".filter").click(function() {
      table.draw();
    });

  });
</script>

@endsection