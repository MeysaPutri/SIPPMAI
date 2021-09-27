@extends('layouts.master')
@section('title', 'Edit Mentor')
@section('section-header')
<div class="section-header">
    <h1>Edit Mentor</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Data User</a></div>
      <div class="breadcrumb-item"><a href="{{ route('mentor') }}">Mentor</a></div>
      <div class="breadcrumb-item">Edit</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
  <form action="{{ route('update.mentor', $mentor->id_mentor) }}" method="POST">
      @csrf
      @method('patch')
      <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
              <div class="card-body"> 
                  <div class="form-group">
                    <label>Periode</label>
                    <input type="text" name="id_periode"  
                    @if (old('id_periode'))
                    value="{{ (old('id_periode')) }}"
                    @else
                    value="{{ $mentor->id_periode }}" 
                    @endif
                    class="form-control">
                  </div>
                  <div class="form-group">
                    <label>NIM</label>
                    <input type="text" name="nip_nim"  
                    @if (old('nip_nim'))
                      value="{{ (old('nip_nim')) }}"
                    @else
                      value="{{ $mentor->nip_nim }}" 
                    @endif
                     class="form-control">
                   </div>
                   <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nim"  
                    @if (old('nim'))
                      value="{{ (old('nim')) }}"
                    @else
                      value="{{ $mentor->nim }}"
                    @endif
                     class="form-control">
                  </div>
              </div>
              <div class="card-footer text-right">
                  <button class="btn btn-primary mr-1" type="submit">Save changes</button>
              </div>
          </div>
      </div>
  </form>
</div>
@endsection

