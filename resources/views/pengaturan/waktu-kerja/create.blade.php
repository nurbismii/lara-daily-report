@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-12">
      @include('message')
      <div class="col-xl-8">
        <div class="card mb-4">
          <h5 class="card-header">Form Waktu Kerja
            <a href="/pengaturan/waktu-kerja" class="text-white btn btn-danger btn-sm float-end">
              <span class="tf-icons bx bx-back"></span>&nbsp; Tutup
            </a>
          </h5>
          <div class="card-body">
            <form action="{{ route('store.waktukerja') }}" method="post">
              @csrf
              <div class="mb-3 row">
                <label for="html5-text-input" class="col-md-2 col-form-label">Waktu Kerja</label>
                <div class="col-md-10">
                  <input class="form-control" name="waktu_kerja" type="text" id="html5-text-input" required />
                </div>
              </div>
              <button type="submit" class="btn btn-primary float-end">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection