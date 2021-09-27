@extends('layouts.master')
@section('title', 'Tambah Kelas')
@section('section-header')
<div class="section-header">
    <h1>Tambah Kelas</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('kelas') }}">Kelas</a></div>
      <div class="breadcrumb-item">Tambah</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
    <form action="{{ route('submit.kelas') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card-body"> 
                    <div class="form-group">
                        <label>Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama Dosen</label>
                        <input type="text" name="id_dosen" class="form-control">
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

