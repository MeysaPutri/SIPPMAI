@extends('layouts.master')
@section('title', 'Data Mentee')
@section('section-header')
<div class="section-header">
    <h1>Data Mentee</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Data User</a></div>
      <div class="breadcrumb-item">Mentee</div>
    </div>
</div>    
@endsection
@section('content')
<div class="buttons">
  <a href="{{ route('create.mentee') }}" class="btn btn-lg btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Tambah Mentee</a>
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
                      <th scope="col">Periode</th>
                      <th scope="col">NIM</th>
                      <th scope="col">Nama</th>
                      <th scope="col">Kelas</th>
                      <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($mentee as $no =>$item)    
                      
                    <tr>
                      <th scope="row">{{ $mentee->firstItem()+$no }}</th>
                      <td>{{ $item->id_periode }}</td>
                      <td>{{ $item->nip_nim }}</td>
                      <td>{{ $item->nim }}</td>
                      <td>{{ $item->id_kelas }}</td>
                      <td>
                        <a href="{{ route('edit.mentee', $item->id_mentee) }}" class="btn btn-info">Edit</a>
                        <a href="#" class="btn btn-danger">Delete</a>
                        <a href="#" class="btn btn-dark">Detail</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                {{ $mentee->links() }}
              </div>
            </div>     
        </div>
    </div>
</div>
@endsection

