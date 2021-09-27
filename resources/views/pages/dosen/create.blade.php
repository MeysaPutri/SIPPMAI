@extends('layouts.master')
@section('title', 'Tambah Dosen')
@section('section-header')
<div class="section-header">
    <h1>Tambah Dosen PAI</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Data User</a></div>
      <div class="breadcrumb-item"><a href="{{ route('dosen') }}">Dosen PAI</a></div>
      <div class="breadcrumb-item">Tambah</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
    <form action="{{ route('submit.dosen') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card-body"> 
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" name="nip_nim" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama_dosen" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>No.HP</label>
                        <input type="text" name="no_hp" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
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

