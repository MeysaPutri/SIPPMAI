@extends('layouts.master')
@section('title', 'Tambah Periode')
@section('section-header')
<div class="section-header">
    <h1>Tambah Periode</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Data User</a></div>
      <div class="breadcrumb-item"><a href="{{ route('periode') }}">Periode</a></div>
      <div class="breadcrumb-item">Tambah</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
  <form action="{{ route('submit.periode') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <form class="needs-validation" novalidate="">
              <div class="card-body"> 
                  <div class="form-group">
                      <label>Periode</label>
                      <input type="text" name="periode" class="form-control" required="">
                  </div>
                  <div class="form-group">
                      <label>Materi</label>
                      <input type="file" name="materi" class="form-control" required="">
                  </div>
              </div>
              <div class="card-footer text-right">
                  <button class="btn btn-primary mr-1" type="submit">Submit</button>
              </div>
            </form>
          </div>
      </div>
  </form>
</div>
@endsection

