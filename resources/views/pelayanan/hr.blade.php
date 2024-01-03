@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-2 mb-2">Data Pelayanan</h4>
  <div class="row">
    <!-- Basic Bootstrap Table -->
    <div class="col-lg-12">
      @include('message')
    </div>
    <div class="col-lg-12">
      <div class="card">
        <h5 class="card-header">Tabel pelayanan</h5>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>PIC</th>
                <th>Nama Karyawan</th>
                <th>Posisi</th>
                <th>Kategori</th>
                <th>Sub kategori</th>
                <th>Tanggal</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @foreach($datas as $no => $data)
              <tr>
                <td>{{ ++$no }}</td>
                <td>{{ getNamaPic($data->nik_pic) }}</td>
                <td>{{ $data->nama_karyawan }}</td>
                <td>{{ $data->posisi }}</td>
                <td>{{ $data->MasterKategoriPelayanan->kategori_pelayanan ?? '' }}</td>
                <td>{{ $data->MasterSubKategoriPelayanan->sub_kategori_pelayanan ?? 'Belum tersedia' }}</td>
                <td>{{ getTanggalIndo($data->tanggal) }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="d-flex justify-content-end mt-2 mx-3">
            {!! $datas->links() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection