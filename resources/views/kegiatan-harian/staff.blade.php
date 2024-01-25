@extends('layouts.app')

@section('content')
<!-- Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<style>
    span.select2.select2-container.select2-container--classic {
        width: 100% !important;
    }

    #loader {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        background-image: none;
        background: rgba(0, 0, 0, 0.75) url("{{ asset('assets/img/loader/loader-horizontal-unscreen.gif') }}") no-repeat center center;
        z-index: 99999;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <form action="{{route('staff.store')}}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                @include('message')
            </div>
            <div class="col-md-3 col-lg-12">
                <div class="card mb-3">
                    <h5 class="card-header">Form kerja harian
                        <a href="/kegiatan-harian/create" class="text-white btn btn-danger btn-sm float-end">
                            <span class="tf-icons bx bx-back"></span>&nbsp; Tutup
                        </a>
                    </h5>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col mb-2">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" value="{{ Auth::user()->name }}" class="form-control" required readonly>
                            </div>
                            <div class="col mb-2">
                                <label for="nik">NIK</label>
                                <input type="text" name="nik" value="{{ Auth::user()->nik }}" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="posisi">Posisi</label>
                                <input type="text" name="posisi" value="{{ Auth::user()->posisi }}" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-2">
                                <label for="jam-masuk-kerja">Jam masuk kerja</label>
                                <input type="text" id="jamMasuk" maxlength="5" name="jam_masuk_kerja" class="form-control" required>
                            </div>
                            <div class="col mb-2">
                                <label for="jam-istirahat">Jam istirahat</label>
                                <input type="text" id="jamIstirahat" maxlength="5" name="jam_istirahat" class="form-control">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-2">
                                <label for="jam-kembali-istirahat">Jam kembali istirahat</label>
                                <input type="text" id="jamKembaliIstirahat" maxlength="5" name="jam_kembali_istirahat" class="form-control">
                            </div>
                            <div class="col mb-2">
                                <label for="jam-pulang-kerja">Jam pulang kerja</label>
                                <input type="text" id="jamPulang" maxlength="5" name="jam_pulang_kerja" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-body control-group after-add-more">
                        <div class="row">
                            <div class="col mb-2">
                                <label for="kegiatan">Kegiatan</label>
                                <input name="kegiatan" class="form-control" required></input>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="jenis-kegiatan">Jenis Kegiatan</label>
                                <select name="jenis_kegiatan_id" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih jenis kegiatan --</option>
                                    @foreach($jenis_kegiatan as $row)
                                    <option value="{{$row->id}}">{{$row->jenis_kegiatan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-2">
                                <label for="kategori-kegiatan">Kategori kegiatan</label>
                                <select name="kategori_kegiatan_id" class="form-select" id="" required>
                                    <option value="" disabled selected>-- Pilih kategori kegiatan --</option>
                                    @foreach($kategori_kegiatan as $row)
                                    <option value="{{$row->id}}">{{$row->kategori_kegiatan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col mb-2">
                                <label for="pic">PIC</label>
                                <select name="pic_id" class="form-select" id="" required>
                                    <option value="" disabled selected>-- Pilih PIC --</option>
                                    @foreach($pic as $row)
                                    <option value="{{$row->id}}">{{$row->pic}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="kendala">Kendala/Masalah</label>
                                <textarea name="kendala" class="form-control" id="" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-2">
                                <label for="mulai-mengerjakan">Mulai mengerjakan</label>
                                <input type="text" id="mulaiMengerjakan" maxlength="5" name="mulai" class="form-control" required>
                            </div>
                            <div class="col mb-2">
                                <label for="selesai-mengerjakan">Selesai mengerjakan</label>
                                <input type="text" id="selesaiMengerjakan" maxlength="5" name="selesai" class="form-control" required>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-2">
                                <label for="status_kegiatan">Status Kegiatan</label>
                                <select name="status_kegiatan" class="form-select" id="" required>
                                    <option value="" disabled selected>-- Pilih status kegiatan --</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="tidak selesai">Tidak selesai</option>
                                </select>
                            </div>
                            <div class="col mb-2">
                                <label for="deadline">Deadline penyelesaian</label>
                                <input type="date" name="deadline" class="form-control" required>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-2">
                                <label for="status-akhir">Status akhir</label>
                                <select name="status_akhir" class="form-select" id="" required>
                                    <option value="" disabled selected>-- Pilih status akhir --</option>
                                    <option value="sesuai">Sesuai</option>
                                    <option value="tidak sesuai">Tidak sesuai</option>
                                </select>
                            </div>
                            <div class="col mb-2">
                                <label for="kuantitas">Kuantitas</label>
                                <input type="number" name="kuantitas" class="form-control" max="100" maxlength="3">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-2 ">
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check pelayanan btn-sm" name="pelayanan" id="pelayanan_off" value="0" checked="" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="pelayanan_off">Tanpa pelayanan</label>
                                    <input type="radio" class="btn-check pelayanan btn-sm" name="pelayanan" id="pelayanan_on" value="1" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="pelayanan_on">Pelayanan</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-pelayanan">
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
                                        @foreach($pelayanan as $row)
                                        <option value="{{ $row->id }}">{{ $row->nama_layanan }}</option>
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
                        </div>
                        <button type="submit" class="btn btn-primary float-end">Simpan</button>
                        <!-- <a type="button" href="#form-kegiatan" class="btn btn-success float-end mx-2 add-more">
                            <span class="tf-icons bx bx-plus"></span>
                            Tambah kegiatan
                        </a> -->
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div id='loader'></div>
</div>

<div class="copy" style="display: none;">
    <div id="form-kegiatan" class="card-body control-group count">
        <div class="row">
            <div class="col mb-2">
                <label for="kegiatan">Kegiatan</label>
                <textarea class="form-control" name="kegiatan[]" cols="30" rows="5" required></textarea>
            </div>
        </div>
        <div class="row mb-3 g-2">
            <div class="col mb-2">
                <label for="email">Jenis Kegiatan</label>
                <select name="jenis_kegiatan_id[]" class="form-select" required>
                    <option value="" disabled selected>-- Pilih jenis kegiatan --</option>
                    @foreach($jenis_kegiatan as $row)
                    <option value="{{$row->id}}">{{$row->jenis_kegiatan}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-3 g-2">
            <div class="col mb-2">
                <label for="kata-sandi">Kategori kegiatan</label>
                <select name="kategori_kegiatan_id[]" class="form-select" id="" required>
                    <option value="" disabled selected>-- Pilih kategori kegiatan --</option>
                    @foreach($kategori_kegiatan as $row)
                    <option value="{{$row->id}}">{{$row->kategori_kegiatan}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col mb-2">
                <label for="email">PIC</label>
                <select name="pic_id[]" class="form-select" id="" required>
                    <option value="" disabled selected>-- Pilih PIC --</option>
                    @foreach($pic as $row)
                    <option value="{{$row->id}}">{{$row->pic}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label for="kendala">Kendala/Masalah</label>
                <textarea name="kendala[]" class="form-control" id="" cols="30" rows="5 "></textarea>
            </div>
        </div>
        <div class="row mb-3 g-2">
            <div class="col mb-2">
                <label class="mb-1" for="nama">Mulai</label>
                <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" title="format harus HH:mm" maxlength="5" placeholder="Format HH:mm" name="mulai[]" class="form-control timepicker2" required>
                <span><small><i><b>Contoh 08:50</b></i></small></span>
            </div>
            <div class="col mb-2">
                <label for="email">Selesai</label>
                <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" title="format harus HH:mm" maxlength="5" placeholder="Format HH:mm" name="selesai[]" class="form-control timepicker2" required>
                <span><small><i><b>Contoh 09:50</b></i></small></span>
            </div>
        </div>

        <div class="row mb-3 g-2">
            <div class="col mb-2">
                <label for="nama">Status Kegiatan</label>
                <select name="status_kegiatan[]" class="form-select" id="" required>
                    <option value="" disabled selected>-- Pilih status kegiatan --</option>
                    <option value="selesai">Selesai</option>
                    <option value="tidak selesai">Tidak selesai</option>
                </select>
            </div>
            <div class="col mb-2">
                <label for="deadline">Deadline penyelesaian</label>
                <input type="date" name="deadline[]" class="form-control" required>
            </div>
        </div>
        <div class="row mb-3 g-2">
            <div class="col mb-2">
                <label for="nama">Status akhir</label>
                <select name="status_akhir[]" class="form-select" id="" required>
                    <option value="" disabled selected>-- Pilih status akhir --</option>
                    <option value="sesuai">Sesuai</option>
                    <option value="tidak sesuai">Tidak sesuai</option>
                </select>
            </div>
            <div class="col mb-2">
                <label for="kuantitas">Kuantitas</label>
                <input type="number" name="kuantitas[]" class="form-control">
            </div>
        </div>
        <div class="row g-2">
            <div class="col mb-2 ">
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check pelayanan" name="pelayanan" id="pelayanan_off" value="0" checked="" autocomplete="off">
                    <label class="btn btn-outline-primary" for="pelayanan_off">Tanpa pelayanan</label>
                    <input type="radio" class="btn-check pelayanan" name="pelayanan" id="pelayanan_on" value="1" autocomplete="off">
                    <label class="btn btn-outline-primary" for="pelayanan_on">Pelayanan</label>
                </div>
            </div>
        </div>
        <div class="form-pelayanan">
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
        </div>
        <button type="button" class="btn btn-danger remove btn-sm">
            <span class="tf-icons bx bx-trash"></span>
            Hapus form kegiatan
        </button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
    $(document).ready(function() {

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

<script type="text/javascript">
    $(document).ready(function() {

        $(".form-pelayanan").css("display", "none");

        $('.pelayanan').change(function() {
            if ($(this).val() === "1") {
                $(".form-pelayanan").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
            } else {
                $(".form-pelayanan").slideUp("fast");
            }
        });

        $(".add-more").click(function() {
            var count = $(".count").length;
            var html = $(".copy").html();
            $(".after-add-more").after(html);
        });

        // saat tombol remove dklik control group akan dihapus 
        $("body").on("click", ".remove", function() {
            $(this).parents(".control-group").remove();
        });

    });

    const jamMasuk = document.getElementById("jamMasuk");
    jamMasuk.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });

    const jamIstirahat = document.getElementById("jamIstirahat");
    jamIstirahat.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });

    const jamKembaliIstirahat = document.getElementById("jamKembaliIstirahat");
    jamKembaliIstirahat.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });

    const jamPulang = document.getElementById("jamPulang");
    jamPulang.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });

    const mulaiMengerjakan = document.getElementById("mulaiMengerjakan");
    mulaiMengerjakan.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });

    const selesaiMengerjakan = document.getElementById("selesaiMengerjakan");
    selesaiMengerjakan.addEventListener("input", function() {
        const value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 2) {
            this.value = value.slice(0, 2) + ":" + value.slice(2);
        }
    });
</script>

@endsection