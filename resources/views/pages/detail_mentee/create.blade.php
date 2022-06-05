@extends('layouts.master')
@section('title', 'Tambah Kelompok')
@section('section-header')
<div class="section-header">
    <h1>Tambah Mentee {{ $kelompok->nama_kel }}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('kelompok') }}">Kelompok</a></div>
      <div class="breadcrumb-item"><a href="#">Kelompok Mentee</a></div>
      <div class="breadcrumb-item">Tambah Mentee</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
    <form action="{{ route('submit.detail_mentee') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card-body"> 
                    <input type="hidden" name="id_kel" class="form-control" value="{{ $id_kelompok }}">
                    <div class="form-group">
                        <label>Mentee</label>
                        <select name="nim" class="form-control select2" required="">
                            <option value="">Pilih Mentee</option>
                            @foreach($mentee as $item)
                                <option value="{{ $item->nim }}">
                                    {{ $item->nim }} - {{ $item->nama_mhs }}</option>
                            @endforeach
                        </select>
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

