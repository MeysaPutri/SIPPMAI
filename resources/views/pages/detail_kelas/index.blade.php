@extends('layouts.master')
@section('title', 'Detail Kelas')
@section('section-header')
<div class="section-header">
    <h1>Mahasiswa {{\Str::ucfirst($kelas->nama_kelas)}}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('kelas') }}">Kelas</a></div>
      <div class="breadcrumb-item">Detail {{\Str::ucfirst($kelas->nama_kelas)}}</div>
    </div>
</div>    
@endsection
@section('content')
@if(session('id_role') == 4)
  <div class="buttons">
    <a href="{{ route('create.detail_kelas', $id_kelas) }}" class="btn btn-lg btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Tambah Mahasiswa</a>
  </div>
@endif
<div class="section-body">
  <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              @foreach ($dosen as $item => $isi)
                <h4>Nama Dosen : {{$isi->nama_dosen}}</h4>
              @endforeach
            </div> 
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">NIM</th>
                      <th scope="col">Nama Mahasiswa</th>
                      <th scope="col">Jurusan</th>
                      <th scope="col">Nama Kelompok</th>
                      <th scope="col">No. Hp</th>
                      @if(session('id_role') == 4)
                          <th scope="col">Aksi</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($mahasiswa as $no =>$item)
                    <tr>
                      <th scope="row">{{ $no+1 }}</th>
                      <td>{{ $item->nim }}</td>
                      <td>{{ $item->nama_mhs }}</td>
                      <td>{{ $item->nama_jurusan }}</td>
                      <td>{{ $item->nama_kel }}</td>
                      <td>{{ $item->no_hp }}</td>
                      @if(session('id_role') == 4)
                            <td>
                              <a onclick="return confirm('Yakin ingin hapus data ini?')" 
                              href="{{ route('delete.detail_kelas', [
                                "id" => $item->nim,
                                "id_kelas" => $id_kelas
                              ]) }}"
                              class="btn btn-danger">Delete</a>
                            </td>
                          @endif
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>             
            </div>
          </div>     
      </div>
  </div>
</div>
@endsection

