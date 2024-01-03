@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <h4 class="fw-bold py-2 mb-2"><span class="text-muted fw-light">Pengaturan / Pelayanan / </span> Kategori </h4>
    <!-- Basic Bootstrap Table -->
    <div class="col-lg-12">
      @include('message')
    </div>
    <div class="col-lg-12 mb-2">
      <div class="card">
        <div class="card-body">
          <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-tambah-kategori-pelayanan" class="mx-2 text-white btn btn-primary btn-sm float-end">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Kategori pelayanan
          </a>
          <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-tambah-sub-kategori-pelayanan" class="mx-2 text-white btn btn-primary btn-sm">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Sub kategori Pelayanan
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
                <th>Kategori pelayanan</th>
                <th>Sub kategori</th>
                <th>Pelayanan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @foreach($datas as $key => $data)
              <tr>
                <td>{{++$key}}</td>
                <td>{{$data->kategori_pelayanan}}</td>
                <td>
                  @foreach($data->subKategoriPelayanan as $val)
                  - {{$val->sub_kategori_pelayanan}} <br>
                  @endforeach
                </td>
                <td>{{$data->masterPelayanan->nama_layanan}}</td>
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

<div class="modal fade" id="modal-tambah-kategori-pelayanan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Form kategori pelayanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('set.kategori.pelayanan.store')}}" method="post">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="pelayanan" class="form-label">Pelayanan</label>
              <select name="pelayanan_id" class="form-select" id="">
                <option value="" disabled selected>- Pilih pelayanan -</option>
                @foreach($pelayanan as $row)
                <option value="{{$row->id}}">{{$row->nama_layanan}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="kategori" class="form-label">Kategori pelayanan</label>
              <input type="text" name="kategori_pelayanan" class="form-control" required />
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

<div class="modal fade" id="modal-tambah-sub-kategori-pelayanan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Form sub kategori pelayanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('set.sub.kategori.pelayanan.store')}}" method="post">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="pelayanan" class="form-label">Kategori pelayanan</label>
              <select name="kategori_pelayanan_id" class="form-select" id="">
                <option value="" disabled selected>- Pilih kategori pelayanan -</option>
                @foreach($datas as $row)
                <option value="{{$row->id}}">{{$row->kategori_pelayanan}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="kategori" class="form-label">Nama sub kategori pelayanan</label>
              <input type="text" name="sub_kategori_pelayanan" class="form-control" required />
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
@endsection