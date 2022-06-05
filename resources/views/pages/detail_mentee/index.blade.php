@extends('layouts.master')
@section('title', 'Data Kelompok')
@section('section-header')
<div class="section-header">
    <h1>Mentee {{\Str::ucfirst($kelompok->nama_kel)}}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item active"><a href="{{ route('kelompok') }}">Kelompok</a></div>
      <div class="breadcrumb-item">{{\Str::ucfirst($kelompok->nama_kel)}}</div>
    </div>
</div>    
@endsection
@section('content')
@if(session('id_role') == 4)
<div class="buttons">
  <a href="{{ route('create.detail_mentee', $id_kelompok) }}" class="btn btn-lg btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Tambah Mentee</a>
</div>
@endif
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-">
            <div class="card">
              <div class="card-header">
                @foreach ($mentor as $item => $isi)
                <h4>Mentor {{$item+1}} : {{$isi->nama_mhs}}</h4>
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
                        <th scope="col">Nama Kelas</th>
                        <th scope="col">Nama Dosen</th>
                        <th scope="col">No. Hp</th>
                        @if(session('id_role') == 4)
                          <th scope="col">Aksi</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>  
                    @foreach ($mentee as $no =>$item) 
                        <tr>
                          <td>{{ $no+1 }}</td>
                          <td>{{ $item->nim }}</td>
                          <td>{{ $item->nama_mhs }}</td>
                          <td>{{ $item->nama_kelas }} - {{ $item->sks }}</td>
                          <td>{{ $item->nama_dosen }}</td>
                          <td>{{ $item->no_hp }}</td>
                          @if(session('id_role') == 4)
                            <td>
                              <a onclick="return confirm('Yakin ingin hapus data ini?')" 
                              href="{{ route('delete.detail_mentee', [
                                "id" => $item->nim,
                                "id_kel" => $id_kelompok
                              ]) }}"
                              class="btn btn-danger">Delete</a>
                            </td>
                          @endif
                        </tr>
                    @endforeach       
                  </table>
                </div>               
              </div>
            </div>     
        </div>
    </div>
</div>
@endsection

