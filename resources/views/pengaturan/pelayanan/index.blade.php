@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <h4 class="fw-bold py-2 mb-2"><span class="text-muted fw-light">Pengaturan /</span> Pelayanan</h4>
    <!-- Basic Bootstrap Table -->
    <div class="col-lg-12">
      @include('message')
    </div>
    <div class="col-lg-12 mb-2">
      <div class="card">
        <div class="card-body">
          <a href="/pengaturan/pelayanan/kategori" class="mx-2 text-white btn btn-primary btn-sm">
            <span class="tf-icons bx bx-chevrons-right"></span>&nbsp; Kategori pelayanan
          </a>
          <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-tambah-pelayanan" class="text-white btn btn-primary btn-sm float-end">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Pelayanan
          </a>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="card">
        <h5 class="card-header">Tabel pelayanan</h5>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Pelayanan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @foreach($datas as $key => $data)
              <tr>
                <td>{{++$key}}</td>
                <td>{{$data->nama_layanan}}</td>
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-horizontal-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalEditPelayanan{{$data->id}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                      <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalHapusPelayanan{{$data->id}}"><i class="bx bx-trash me-1"></i> Hapus</a>
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

<!-- Buat pelayanan modal -->
<div class="modal fade" id="modal-tambah-pelayanan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Form pelayanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('set.pelayanan.store')}}" method="post">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="pelayanan" class="form-label">Pelayanan</label>
              <input type="text" name="nama_layanan" class="form-control" required />
            </div>
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
<!-- Buat pelayanan modal end -->

<!-- Edit pelayanan modal -->
@foreach($datas as $data)
<div class="modal fade" id="modalEditPelayanan{{$data->id}}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Form edit pelayanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('set.pelayanan.update', $data->id)}}" method="post">
        @csrf
        {{method_field('patch')}}
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="pelayanan" class="form-label">Pelayanan</label>
              <input type="text" name="nama_layanan" value="{{$data->nama_layanan}}" class="form-control" required />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Tutup
          </button>
          <button type="submit" class="btn btn-primary">Perbarui</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
<!-- Edit pelayanan modal end -->

<!-- Hapus pelayanan modal -->
@foreach($datas as $data)
<div class="modal modal-top fade" id="modalHapusPelayanan{{$data->id}}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Konfirmasi permintaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('set.pelayanan.destroy', $data->id)}}" method="post">
        @csrf
        {{method_field('delete')}}
        <div class="modal-body">
          Apa kamu yakin ingin menghapus pelayanan ini ({{ $data->nama_layanan }}) ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Tutup
          </button>
          <button type="submit" class="btn btn-primary">Yakin</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
<!-- Hapus pelayanan modal end -->

@endsection