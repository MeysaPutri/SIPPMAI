@extends('layouts.master')
@section('title', 'Edit Periode')
@section('section-header')
<div class="section-header">
    <h1>Edit Periode</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('periode') }}">Periode</a></div>
      <div class="breadcrumb-item">Edit</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
  <form action="{{ route('update.periode', $periode->id_periode) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('patch')
      <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
              <div class="card-body"> 
                  <div class="form-group">
                    <label>Periode</label>
                    <input type="text" name="periode"  
                    @if (old('periode'))
                    value="{{ (old('periode')) }}"
                    @else
                    value="{{ $periode->periode }}" 
                    @endif
                    class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Materi</label>
                    <input type="file" class="form-control" id="materi" name="materi">
                    <br><br>
                    @if($periode->materi)
                    <a href="{{ asset('materi/'.$periode->materi) }}">{{ 
                    $periode->materi }}</a>
                    <input type="hidden" name="materiOld" value="{{ $periode->materi }}"class="form-control">
                    @else
                      <p>Kamu belum punya materi</p>
                    @endif
                     
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

