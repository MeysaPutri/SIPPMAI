@extends('layouts.master')
@section('title', 'Tambah Mentor')
@section('section-header')
<div class="section-header">
    <h1>Tambah Mentor</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Data User</a></div>
      <div class="breadcrumb-item"><a href="{{ route('mentor') }}">Mentor</a></div>
      <div class="breadcrumb-item">Tambah</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
  <form action="{{ route('submit.mentor') }}" method="POST">
      @csrf
      <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
              <div class="card-body"> 
                  <div class="form-group">
                      <label>Periode</label>
                      <input type="text" name="id_periode" class="form-control">
                  </div>
                  <div class="form-group">
                      <label>NIM</label>
                      <input type="text" name="nip_nim" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nim" class="form-control">
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

