@extends('layouts.master')
@section('title', 'Detail Laporan')
@section('section-header')
<div class="section-header">
    <h1>Detail Laporan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('laporan') }}">Laporan Mentoring</a></div>
      <div class="breadcrumb-item">Detail</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <table cellpadding = "15">
            <tr>
              <th>Periode</th>
              <td>:</td>
              <td>{{ $items->periode }}</td>
            </tr>
            <tr>
              <th>Nama Mentor</th>
              <td>:</td>
              <td>{{ $items->nama_mhs }}</td>
            </tr>
            <tr>
              <th>Nama Kelompok</th>
              <td>:</td>
              <td>{{ $items->nama_kel }}</td>
            </tr>
            <tr>
              <th>Pertemuan</th>
              <td>:</td>
              <td>{{ $items->pertemuan }}</td>
            </tr>
            <tr>
              <th>Tanggal</th>
              <td>:</td>
              <td>{{ $items->tgl }}</td>
            </tr>
            <tr>
              <th>Laporan</th>
              <td>:</td>
              <td>{{ $items->laporan }}</td>
            </tr>
            <tr>
              <th>Keterangan</th>
              <td>:</td>
              <td>{{ $items->keterangan }}</td>
            </tr>
            <tr>
              <th>Jumlah mentee yang hadir</th>
              <td>:</td>
              <td>{{ $items->mentee_hadir }}</td>
            </tr>
            <tr>
              <th>Gambar</th>
              <td>:</td>
              <td><a target="_blank" href="{{  asset('gambar/'.$items->gambar)  }}">{{ $items->gambar }}</a></td>
            </tr>           
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

