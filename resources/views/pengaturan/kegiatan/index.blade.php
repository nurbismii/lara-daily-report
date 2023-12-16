@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <h4 class="fw-bold py-2 mb-2"><span class="text-muted fw-light">Pengaturan /</span> Kegiatan</h4>
    <!-- Basic Bootstrap Table -->
    <div class="col-lg-12">
      @include('message')
    </div>
    <div class="col-lg-12">
      <div class="card">
        <h5 class="card-header">Tabel kegiatan
          <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-tambah-kegiatan" class="text-white btn btn-primary btn-sm float-end">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Kegiatan
          </a>
        </h5>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Kegiatan</th>
                <th>Keterangan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @foreach($jenis_kegiatan as $data)
              <tr>
                <td>{{ ++$no }}</td>
                <td>{{ $data->jenis_kegiatan }}</td>
                <td>{{ $data->keterangan }}</td>
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-horizontal-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalEditKegiatan{{$data->id}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                      <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalHapusKegiatan{{$data->id}}"><i class="bx bx-trash me-1"></i> Hapus</a>
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-tambah-kegiatan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Form jenis kegiatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('store.jeniskegiatan')}}" method="post">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="jenis-kegiatan" class="form-label">Jenis Kegiatan</label>
              <input type="text" name="jenis_kegiatan" class="form-control" required/>
            </div>
          </div>
          <div class="col mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" name="keterangan" cols="30" rows="10"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Tutup
          </button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@foreach($jenis_kegiatan as $data)
<div class="modal fade" id="modalEditKegiatan{{$data->id}}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Form jenis kegiatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('update.jeniskegiatan', $data->id)}}" method="post">
        @csrf
        {{method_field('patch')}}
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="jenis-kegiatan" class="form-label">Jenis Kegiatan</label>
              <input type="text" name="jenis_kegiatan" value="{{$data->jenis_kegiatan}}" class="form-control" />
            </div>
          </div>
          <div class="col mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" name="keterangan" cols="10" rows="5">{{$data->keterangan}}</textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Tutup
          </button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

@foreach($jenis_kegiatan as $data)
<div class="modal modal-top fade" id="modalHapusKegiatan{{$data->id}}" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{route('delete.jeniskegiatan', $data->id)}}" method="post" class="modal-content">
      @csrf
      {{method_field('delete')}}
      <div class="modal-header">
        <h5 class="modal-title" id="modalTopTitle">Konfirmasi permintaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Kamu yakin ingin menghapus jenis kegiatan ini [ {{$data->jenis_kegiatan}} ]
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Tutup
        </button>
        <button type="submit" class="btn btn-primary">Hapus</button>
      </div>
    </form>
  </div>
</div>
@endforeach

@endsection