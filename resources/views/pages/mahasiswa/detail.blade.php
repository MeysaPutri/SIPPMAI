@extends('layouts.master')
@section('title', 'Detail Mahasiswa')
@section('section-header')
<div class="section-header">
    <h1>Detail Mahasiswa</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Data User</a></div>
      <div class="breadcrumb-item"><a href="{{ route('mahasiswa') }}">Mahasiswa</a></div>
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
              <th>NIM</th>
              <td>:</td>
              <td>{{ $items->nim }}</td>
            </tr>
            <tr>
              <th>Nama</th>
              <td>:</td>
              <td>{{ $items->nama_mhs }}</td>
            </tr>
            <tr>
              <th>Jenis Kelamin</th>
              <td>:</td>
              <td>{{ $items->jenis_kelamin }}</td>
            </tr>
            <tr>
              <th>Tempat/Tanggal Lahir</th>
              <td>:</td>
              <td>{{ $items->tempat_lahir }}/ {{ $items->tgl_lahir }}</td>
            </tr>
            <tr>
              <th>Fakultas</th>
              <td>:</td>
              <td>{{ $items->nama_fakultas }}</td>
            </tr>
            <tr>
              <th>Jurusan</th>
              <td>:</td>
              <td>{{ $items->nama_jurusan }}</td>
            </tr>
            <tr>
              <th>Alamat</th>
              <td>:</td>
              <td>{{ $items->alamat }}</td>
            </tr>
            <tr>
              <th>No. HP</th>
              <td>:</td>
              <td>{{ $items->no_hp }}</td>
            </tr>
            <tr>
              <th>Email</th>
              <td>:</td>
              <td>{{ $items->email }}</td>
            </tr>
            <tr>
              <th>Golongan Darah</th>
              <td>:</td>
              <td>{{ $items->gol_dar }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

