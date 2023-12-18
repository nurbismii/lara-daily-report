@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"> Profile </h4>
  <div class="row">
    <div class="col-lg-12">
      @include('message')
    </div>
    <div class="col-md-12">
      <div class="card mb-4">
        <h5 class="card-header">Data akun</h5>
        <!-- Account -->
        <div class="card-body">
          <div class="d-flex align-items-start align-items-sm-center gap-4">
            <img src="{{ asset('foto-profil/' . Auth::user()->nik . '/' . Auth::user()->foto ) }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
            <form action="{{ route('update.fotoProfil') }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="button-wrapper">
                <label for="upload" tabindex="0">
                  <span class="d-none d-sm-block mb-2">Unggah foto baru</span>
                  <i class="bx bx-upload d-block d-sm-none"></i>
                  <input type="file" id="upload" name="foto" class="account-file-input" accept="image/png, image/jpeg">
                  <button type="submit" class="btn btn-primary">Simpan foto</button>
                </label>
                <p class="text-muted mb-0 mt-2">Allowed JPG, GIF or PNG. Max size of 10MB</p>
              </div>
            </form>
          </div>
        </div>
        <hr class="my-0">
        <div class="card-body">
          <form id="formAccountSettings" action="{{ route('update.pengguna', Auth::user()->id) }}" method="POST">
            @csrf
            {{ method_field('patch')}}
            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="name" class="form-label">Nama</label>
                <input class="form-control" type="text" name="name" value="{{ $data->name }}" autofocus="" readonly>
              </div>
              <div class="mb-3 col-md-6">
                <label for="email" class="form-label">Email</label>
                <input class="form-control" type="email" name="email" value="{{ $data->email }}">
              </div>
              <div class="mb-3 col-md-6">
                <label for="email" class="form-label">NIK</label>
                <input class="form-control" type="text" name="nik" value="{{ $data->nik }}" readonly>
              </div>
              <div class="mb-3 col-md-6">
                <label for="organization" class="form-label">Jabatan</label>
                <input type="text" class="form-control" name="jabatan" value="{{ $data->jabatan }}" readonly>
              </div>
              <div class="mb-3 col-md-12">
                <label for="organization" class="form-label">Posisi</label>
                <input type="text" class="form-control" name="posisi" value="{{ $data->posisi }}">
              </div>
              <div class="mb-3 col-md-6">
                <label for="kata-sandi" class="form-label">Kata sandi baru</label>
                <input class="form-control" type="password" name="kata_sandi">
              </div>
              <div class="mb-3 col-md-6">
                <label for="konfirmasi-sandi" class="form-label">Konfirmasi kata sandi</label>
                <input type="password" class="form-control" name="konfirmasi_kata_sandi">
              </div>
            </div>
            <div class="mt-2">
              <button type="submit" class="btn btn-primary me-2">Simpan perubahan</button>
              <button type="reset" class="btn btn-outline-secondary">Reset</button>
            </div>
          </form>
        </div>
        <!-- /Account -->
      </div>
    </div>
  </div>
</div>

@endsection