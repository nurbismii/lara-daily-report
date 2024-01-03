@extends('layouts.app')

@section('content')
<!-- Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<style>
  span.select2.select2-container.select2-container--classic {
    width: 100% !important;
  }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <h4 class="fw-bold py-2 mb-2">Form pelayanan</h4>
    <!-- Basic Bootstrap Table -->
    <div class="col-lg-12">
      @include('message')
    </div>
    <div class="col-lg-12">
      <form action="{{ route('pelayanan.store') }}" method="post">
        @csrf
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col mb-2">
                <label for="search">Daftar karyawan</label>
                <select name="search" class="form-select search" id="nik"></select>
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-2">
                <label for="nama">Nama</label>
                <input type="text" id="nama_karyawan" name="nama_karyawan" class="form-control" required readonly>
              </div>
              <div class="col mb-2">
                <label for="nik">NIK</label>
                <input type="text" name="nik_karyawan" class="form-control nik_karyawan" required readonly>
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-2">
                <label for="departemen">Departemen</label>
                <input type="text" id="departemen" name="departemen" class="form-control" required readonly>
              </div>
              <div class="col mb-2">
                <label for="divisi">Divisi</label>
                <input type="text" id="divisi" name="divisi" class="form-control nik_karyawan" required readonly>
              </div>
            </div>
            <div class="row">
              <div class="col mb-2">
                <label for="posisi">Posisi</label>
                <input type="text" id="posisi" name="posisi" class="form-control" required readonly>
              </div>
            </div>
            <div class="row">
              <div class="col mb-2">
                <label for="pelayanan">Pelayanan</label>
                <select name="pelayanan_id" class="form-select" id="pelayanan-dropdown">
                  <option value="" disabled selected>- Pilih pelayanan -</option>
                  @foreach($pelayanan as $val)
                  <option value="{{ $val->id }}">{{ $val->nama_layanan }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col mb-2">
                <label for="kategori-pelayanan">Kategori pelayanan</label>
                <select name="kategori_pelayanan_id" class="form-select" id="kategori-dropdown"></select>
              </div>
            </div>
            <div class="row">
              <div class="col mb-2">
                <label for="pelayanan">Sub Kategori pelayanan</label>
                <select name="sub_kategori_pelayanan_id" class="form-select" id="sub-kategori-dropdown"></select>
              </div>
            </div>
            <div class="row">
              <div class="col mb-2">
                <label for="keperluan">Keperluan</label>
                <textarea name="keperluan" cols="30" rows="5" class="form-control"></textarea>
              </div>
            </div>
            <div class="row">
              <div class="col mb-2">
                <label for="pic">Person in Charge</label>
                <input type="text" value="{{ Auth::user()->name }}" class="form-control" required readonly>
                <input type="hidden" name="nik_pic" value="{{ Auth::user()->nik }}" class="form-control" required readonly>
              </div>
            </div>
            <button type="submit" class="btn btn-primary float-end">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
  $(document).ready(function() {

    /*------------------------------------------
    --------------------------------------------
    Country Dropdown Change Event
    --------------------------------------------
    --------------------------------------------*/
    $('#pelayanan-dropdown').on('change', function() {
      var idPelayanan = this.value;
      $("#kategori-dropdown").html('');
      $.ajax({
        url: "{{url('fetch/kategori-pelayanan')}}",
        type: "POST",
        data: {
          pelayanan_id: idPelayanan,
          _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function(result) {
          $('#kategori-dropdown').html('<option value="">-- Pilih kategori --</option>');
          $.each(result.kategori, function(key, value) {
            $("#kategori-dropdown").append('<option value="' + value
              .id + '">' + value.kategori_pelayanan + '</option>');
          });
          $('#sub-kategori-dropdown').html('<option value="">-- Pilih sub kategori --</option>');
        }
      });
    });

    /*------------------------------------------
    --------------------------------------------
    State Dropdown Change Event
    --------------------------------------------
    --------------------------------------------*/
    $('#kategori-dropdown').on('change', function() {
      var kategori_id = this.value;
      $("#sub-kategori-dropdown").html('');
      $.ajax({
        url: "{{url('fetch/sub-kategori-pelayanan')}}",
        type: "POST",
        data: {
          sub_kategori_id: kategori_id,
          _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function(res) {
          $('#sub-kategori-dropdown').html('<option value="">-- Pilih sub kategori --</option>');
          $.each(res.sub_kategori, function(key, value) {
            $("#sub-kategori-dropdown").append('<option value="' + value
              .id + '">' + value.sub_kategori_pelayanan + '</option>');
          });
        }
      });
    });

  });
</script>

<script type="text/javascript">
  $('.search').select2({
    width: 'resolve',
    theme: 'default',
    placeholder: 'Cari karyawan...',
    ajax: {
      url: '/pelayanan/cari-karyawan',
      dataType: 'json',
      delay: 250,
      processResults: function(data) {
        return {
          results: $.map(data, function(item) {
            return {
              text: item.nik + ' - ' + item.nama_karyawan,
              id: item.nik
            }
          })
        };
      },
      cache: true
    }
  });

  $('#nik').on('change', function() {
    var id = $(this).val();
    if (id) {
      $.ajax({
        url: '/pelayanan/detail/' + id,
        type: "GET",
        data: {
          "_token": "{{ csrf_token() }}"
        },
        dataType: "json",
        success: function(data) {
          if (data) {
            $('.nik_karyawan').val(data.nik);
            $('#nama_karyawan').val(data.nama_karyawan);
            $('#departemen').val(data.departemen);
            $('#divisi').val(data.nama_divisi);
            $('#posisi').val(data.posisi);
            $('#jabatan').val(data.jabatan);
            $('#sisa_cuti').val(data.sisa_cuti);
          }
        }
      });
    }
  });
</script>

@endsection