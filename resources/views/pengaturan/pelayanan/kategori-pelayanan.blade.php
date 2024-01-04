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
          <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-tambah-sub-kategori-pelayanan" class="mx-1 text-white btn btn-primary float-end btn-sm">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Sub kategori Pelayanan
          </a>
          <a href="/pengaturan/pelayanan" class="mx-1 text-white btn btn-secondary btn-sm">
            <span class="tf-icons bx bx-chevrons-left"></span>&nbsp; Kembali
          </a>
          <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-tambah-kategori-pelayanan" class="text-white btn btn-primary btn-sm float-end">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Kategori pelayanan
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
                      <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalEditKategoriPel{{$data->id}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                      <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalHapusKategoriPel{{$data->id}}"><i class="bx bx-trash me-1"></i> Hapus</a>
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

<!-- Buat kategori pelayanan modal -->
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
              <select name="pelayanan_id" class="form-select" id="" required>
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
<!-- Buat kategori pelayanan modal end -->

<!-- Buat sub kategori pelayanan modal -->
<div class="modal fade" id="modal-tambah-sub-kategori-pelayanan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
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
              <select name="kategori_pelayanan_id" class="form-select" required>
                <option value="" disabled selected>- Pilih kategori pelayanan -</option>
                @foreach($datas as $row)
                <option value="{{$row->id}}">{{$row->masterPelayanan->nama_layanan}} - {{$row->kategori_pelayanan}}</option>
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
<!-- Buat sub kategori pelayanan modal end -->

<!-- Edit kategori pelayanan modal -->
@foreach($datas as $data)
<div class="modal fade" id="modalEditKategoriPel{{$data->id}}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Form edit kategori pelayanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <form action="#" method="post">
            <div class="mb-3 mt-3 row">
              <label for="html5-text-input" class="col-md-2 col-form-label">Pelayanan</label>
              <div class="col-md-10">
                <div class="input-group">
                  <input type="text" class="form-control" value="{{$data->masterPelayanan->nama_layanan}}" readonly>
                </div>
              </div>
            </div>
          </form>
          <div class="dropdown-divider"></div>
          <form action="{{route('set.kategori.pelayanan.update', $data->id)}}" method="post">
            @csrf
            {{method_field('patch')}}
            <div class="mb-3 mt-3 row">
              <label for="html5-text-input" class="col-md-2 col-form-label">Kategori Pelayanan</label>
              <div class="col-md-10">
                <div class="input-group">
                  <input type="text" name="kategori_pelayanan" class="form-control" value="{{$data->kategori_pelayanan}}">
                  <button class="btn btn-outline-primary" type="submit">Simpan perubahan</button>
                </div>
              </div>
            </div>
          </form>
          <div class="dropdown-divider"></div>
          <div class="col-md-12">
            @php
            $no = 1;
            @endphp
            @foreach($data->subKategoriPelayanan as $val)
            <form action="{{ route('set.sub.kategori.pelayanan.update')}}" method="post">
              @csrf
              <div class="mb-3 mt-3 row">
                <label for="html5-text-input" class="col-md-2 col-form-label">Sub Kategori {{$no++}}</label>
                <div class="col-md-10">
                  <div class="input-group">
                    <input type="hidden" class="form-control" name="id" value="{{$val->id}}">
                    <input type="text" class="form-control" name="sub_kategori_pelayanan" value="{{$val->sub_kategori_pelayanan}}">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Opsi
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li><button type="submit" class="dropdown-item">Simpan perubahan</button></li>
                      <li><a class="dropdown-item" href="{{ route('set.sub.kategori.pelayanan.destroy', $val->id)}}" onclick="return confirm('Kamu yakin ingin anggota tim ini [ {{$val->sub_kategori_pelayanan}} ]')">Hapus anggota</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </form>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach
<!-- Edit kategori pelayanan modal -->

<!-- Hapus kategori & sub kategori pelayanan modal -->
@foreach($datas as $data)
<div class="modal modal-top fade" id="modalHapusKategoriPel{{$data->id}}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel4">Konfirmasi permintaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('set.kategori.pelayanan.destroy', $data->id) }}" method="post">
        @csrf
        {{method_field('delete')}}
        <div class="modal-body">
          Apa kamu yakin ingin menghapus data kategori pelayanan {{($data->kategori_pelayanan)}} ?
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
<!-- Hapus kategori & sub kategori pelayanan modal end -->

@endsection