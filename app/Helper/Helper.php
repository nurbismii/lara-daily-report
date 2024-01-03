<?php

use App\Models\KategoriKegiatan;
use App\Models\Kegiatan;
use App\Models\PIC;
use App\Models\User;

function getNamaPic($id)
{
	$nama = User::where('nik', $id)->pluck('name')->implode("");
	return $nama;
}

function getJenisKegiatanById($id)
{
	$nama = Kegiatan::where('id', $id)->pluck('jenis_kegiatan')->implode("");
	return $nama;
}

function getKategoriKegiatanById($id)
{
	$nama = KategoriKegiatan::where('id', $id)->pluck('kategori_kegiatan')->implode("");
	return $nama;
}

function getPicById($id)
{
	$nama = PIC::where('id', $id)->pluck('pic')->implode("");
	return $nama;
}

function getTanggalIndo($tanggal)
{
	if (isset($tanggal)) {
		$bulan = array(
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);

		// variabel pecahkan 0 = tanggal
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tahun

		return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
	}
	return '';
}

function getKegiatanTerpopuler($kegiatan_harian)
{
	$kategori = array();
	$data = array();

	foreach ($kegiatan_harian as $row) {

		$kategori[] = KategoriKegiatan::where('id', $row->kategori_kegiatan_id)->pluck('kategori_kegiatan')->implode('');
	}

	$kategori_arr = array_replace($kategori, array_fill_keys(array_keys($kategori, null), ''));
	$jumlah_kategori = array_count_values($kategori_arr);
	arsort($jumlah_kategori);

	foreach ($jumlah_kategori as $key => $val) {

		$data[] = [
			'kategori' => $key,
			'total' => $val
		];
	}
	return $data;
}

if (!function_exists('totalKegiatanHarian')) {
	function totalKegiatanHarian($data)
	{
		$total_kategori = array();

		if (count($data) >= 4) {
			$count = 4;
		} else {
			$count = count($data);
		}

		for ($i = 0; $i < $count; $i++) {
			$total_kategori[] = isset($data[$i]['total']) == true ? $data[$i]['total'] : 0;

			if ($i == $count)
				break;
		}
		return $total_kategori;
	}
}

if (!function_exists('daftarNamaKategoriKegiatan')) {
	function daftarNamaKategoriKegiatan($data)
	{
		$kategori = array();

		if (count($data) >= 4) {
			$count = 4;
		} else {
			$count = count($data);
		}

		for ($i = 0; $i < $count; $i++) {
			$kategori[] = isset($data[$i]['kategori']) == true ? $data[$i]['kategori'] : 0;

			if ($i == $count)
				break;
		}
		return $kategori;
	}
}

function getJenisKegiatanTerpopuler($kegiatan_harian)
{
	$jenis_kegiatan = array();
	$data = array();

	foreach ($kegiatan_harian as $row) {

		$jenis_kegiatan[] = Kegiatan::where('id', $row->jenis_kegiatan_id)->pluck('jenis_kegiatan')->implode('');
	}

	$jenis_kegiatan_arr = array_replace($jenis_kegiatan, array_fill_keys(array_keys($jenis_kegiatan, null), ''));
	$jumlah_jenis_kegiatan = array_count_values($jenis_kegiatan_arr);
	arsort($jumlah_jenis_kegiatan);

	foreach ($jumlah_jenis_kegiatan as $key => $val) {

		$data[] = [
			'jenis_kegiatan' => $key,
			'total' => $val
		];
	}
	return $data;
}

if (!function_exists('totalJenisKegiatan')) {
	function totalJenisKegiatan($data)
	{
		$total_jenis_kegiatan = array();

		if (count($data) >= 4) {
			$count = 4;
		} else {
			$count = count($data);
		}

		for ($i = 0; $i < $count; $i++) {
			$total_jenis_kegiatan[] = isset($data[$i]['total']) == true ? $data[$i]['total'] : 0;

			if ($i == $count)
				break;
		}
		return $total_jenis_kegiatan;
	}
}

if (!function_exists('daftarNamaJenisKegiatan')) {
	function daftarNamaJenisKegiatan($data)
	{
		$jenis_kegiatan = array();

		if (count($data) >= 4) {
			$count = 4;
		} else {
			$count = count($data);
		}

		for ($i = 0; $i < $count; $i++) {
			$jenis_kegiatan[] = isset($data[$i]['jenis_kegiatan']) == true ? $data[$i]['jenis_kegiatan'] : 0;

			if ($i == $count)
				break;
		}
		return $jenis_kegiatan;
	}
}
