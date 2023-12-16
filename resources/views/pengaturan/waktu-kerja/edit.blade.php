@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <h4 class="fw-bold py-2 mb-2"><span class="text-muted fw-light">Pengaturan / Waktu Kerja /</span> Edit waktu kerja & kategori</h4>
    <div class="col-lg-12">
      @include('message')
    </div>
    <div>
      <a href="/pengaturan/waktu-kerja" class="text-white btn btn-danger btn-sm float-end mb-3">
        <span class="tf-icons bx bx-back"></span>&nbsp; Tutup
      </a>
    </div>
    <div class="col-xl-5">
      <div class="card mb-4">
        <h5 class="card-header">Form edit Waktu Kerja</h5>
        <div class="card-body">
          <form action="{{ route('update.waktukerja', $data->id) }}" method="post">
            @csrf
            {{method_field('patch')}}
            <div class="mb-3 row">
              <label for="html5-text-input" class="col-md-2 col-form-label">Waktu Kerja</label>
              <div class="col-md-10">
                <input class="form-control" type="text" name="waktu_kerja" value="{{ $data->waktu_kerja }}">
              </div>
            </div>
            <button type="submit" class="btn btn-primary float-end">Simpan perubahan</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-xl-7">
      <div class="card mb-4">
        <h5 class="card-header">Form edit kategori waktu kerja </h5>
        <div class="card-body">
          @foreach($data->kategori_waktu_kerja as $kategori)
          <form action="{{route('update.kategoriwaktukerja', $kategori->id)}}" method="post">
            @csrf
            {{method_field('patch')}}
            <div class="mb-3 row">
              <label for="html5-text-input" class="col-md-2 col-form-label">Kategori {{++$no}}</label>
              <div class="col-md-10">
                <div class="input-group">
                  <input type="text" class="form-control" id="" name="kategori_waktu_kerja" value="{{ $kategori->kategori_waktu_kerja }}" aria-label="Text input with dropdown button">
                  <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Opsi
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li><button type="submit" class="dropdown-item">Simpan perubahan</button></li>
                    <li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalDeleteKategoriWaktukerja{{$kategori->id}}">Hapus kategori</a></li>
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

@foreach($data->kategori_waktu_kerja as $kategori)
<div class="modal modal-top fade" id="modalDeleteKategoriWaktukerja{{$kategori->id}}" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{route('delete.kategoriwaktukerja', $kategori->id)}}" method="post" class="modal-content">
      @csrf
      {{method_field('delete')}}
      <div class="modal-header">
        <h5 class="modal-title" id="modalTopTitle">Konfirmasi permintaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Kamu yakin ingin menghapus kategori [ {{ $kategori->kategori_waktu_kerja }} ] ini ?
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