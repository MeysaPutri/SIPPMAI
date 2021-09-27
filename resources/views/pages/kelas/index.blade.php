@extends('layouts.master')
@section('title', 'Data Kelas')
@section('section-header')
<div class="section-header">
    <h1>Data Kelas</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Kelas</div>
    </div>
</div>    
@endsection
@section('content')
<div class="buttons">
  <a href="{{ route('create.kelas') }}" class="btn btn-lg btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Tambah Kelas</a>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-">
            <div class="card">
              <div class="card-header">
                <h4>Simple</h4>
              </div>
              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">Nama Kelas</th>
                      <th scope="col">Nama Dosen</th>
                      <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($kelas as $no =>$item)        
                    <tr>
                      <th scope="row">{{ $kelas->firstItem()+$no }}</th>
                      <td>{{ $item->nama_kelas }}</td>
                      <td>{{ $item->id_dosen }}</td>
                      <td>
                        <a href="{{ route('edit.kelas', $item->id_kelas) }}" class="btn btn-info">Edit</a>
                        <a href="#" class="btn btn-danger">Delete</a>
                        <a href="#" class="btn btn-dark">Detail</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                {{ $kelas->links() }}
              </div>
            </div>     
        </div>
    </div>
</div>
@endsection

