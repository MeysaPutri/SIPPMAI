@extends('layouts.master')
@section('title', 'Edit Kelompok')
@section('section-header')
<div class="section-header">
    <h1>Edit Kelompok</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('kelompok') }}">Kelompok</a></div>
      <div class="breadcrumb-item">Edit</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
    <form action="{{ route('update.kelompok', $kelompok->id_kel) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card-body"> 
                    <div class="form-group">
                        <label>Nama_kelompok</label>
                        <input type="text" name="nama_kel"  
                        @if (old('nama_kel'))
                        value="{{ (old('nama_kel')) }}"
                        @else
                        value="{{ $kelompok->nama_kel }}" 
                        @endif
                        class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Periode</label>
                        <input type="text" name="id_periode"  
                        @if (old('id_periode'))
                        value="{{ (old('id_periode')) }}"
                        @else
                        value="{{ $kelompok->id_periode }}" 
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

