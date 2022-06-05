@extends('layouts.master')
@section('title', 'Data Mahasiswa')
@section('section-header')
<div class="section-header">
    <h1>Data Mahasiswa</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Data User</a></div>
      <div class="breadcrumb-item">Mahasiswa</div>
    </div>
</div>    
@endsection
@section('content')
<div class="buttons">
  <a href="{{ route('create.mahasiswa') }}" class="btn btn-lg btn-icon icon-left btn-primary"><i class="far fa-edit"></i>Tambah Mahasiswa</a>
</div>
<div class="section-body">
    <div class="row"> 
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="table-1">
                    <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jurusan</th>
                        <th scope="col">No. Hp</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($mahasiswa as $no =>$item)      
                      <tr>
                        <th scope="row">{{ $no+1}}</th>
                        <td>{{ $item->nim }}</td>
                        <td>{{ $item->nama_mhs }}</td>
                        <td>{{ $item->nama_jurusan }}</td>
                        <td>{{ $item->no_hp }}</td>
                        <td>
                          <a href="{{ route('edit.mahasiswa', $item->nim) }}" class="btn btn-info">Edit</a>
                          <a onclick="return confirm('Yakin ingin hapus data ini?')" href="{{ route('delete.mahasiswa', $item->nim) }}" class="btn btn-danger">Delete</a>
                          <a href="{{ route('show.mahasiswa', $item->nim) }}" class="btn btn-dark">Detail</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  {{-- {{ $mahasiswa->links() }} --}}
                </div>
              </div>
            </div>     
        </div>
    </div>
</div>
@endsection