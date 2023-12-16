@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <h4 class="fw-bold py-2 mb-2"><span class="text-muted fw-light">Pengaturan / Waktu Kerja /</span> Tambah kategori</h4>
    <div class="col-lg-12">
      @include('message')
    </div>
    <div class="col-xl-8">
      <!-- HTML5 Inputs -->
      <div class="card mb-4">
        <h5 class="card-header">Form Kategori Waktu Kerja
          <a href="/pengaturan/waktu-kerja" class="text-white btn btn-danger btn-sm float-end">
            <span class="tf-icons bx bx-back"></span>&nbsp; Tutup
          </a>
        </h5>
        <div class="card-body">
          <form action="{{ route('store.kategoriwaktukerja') }}" method="post">
            @csrf
            <div class="mb-3 row">
              <label for="html5-text-input" class="col-md-2 col-form-label">Waktu kerja</label>
              <div class="col-md-10">
                <input class="form-control" type="hidden" name="waktu_kerja_id" value="{{ $data->id }}">
                <input class="form-control" type="text" name="waktu_kerja" value="{{ $data->waktu_kerja }}" readonly>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="html5-text-input" class="col-md-2 col-form-label">Kategori</label>
              <div class="col-md-10">
                <input class="form-control" type="text" name="kategori_waktu_kerja" />
              </div>
            </div>
            <button type="submit" class="btn btn-primary float-end">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endsection