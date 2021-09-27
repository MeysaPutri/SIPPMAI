@extends('layouts.master')
@section('title', 'Data Dosen')
@section('section-header')
<div class="section-header">
    <h1>Data Dosen PAI</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Data User</a></div>
      <div class="breadcrumb-item">Dosen PAI</div>
    </div>
</div>    
@endsection
@section('content')
<div class="buttons">
  <a href="{{ route('create.dosen') }}" class="btn btn-lg btn-icon icon-left btn-primary float:right"><i class="far fa-edit"></i> Tambah Dosen</a>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4>Simple</h4>
              </div>
              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">NIP</th>
                      <th scope="col">Nama</th>
                      <th scope="col">No. HP</th>
                      <th scope="col">Email</th>
                      <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($dosen as $no =>$item)    
                      
                    <tr>
                      <th scope="row">{{ $dosen->firstItem()+$no }}</th>
                      <td>{{ $item->nip_nim }}</td>
                      <td>{{ $item->nama_dosen }}</td>
                      <td>{{ $item->no_hp }}</td>
                      <td>{{ $item->email }}</td>
                      <td>
                        <a href="{{ route('edit.dosen', $item->id_dosen) }}" class="btn btn-info">Edit</a>
                        <a href="#" class="btn btn-danger">Delete</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                {{ $dosen->links() }}
              </div>
            </div>     
        </div>
    </div>
</div>


@endsection

