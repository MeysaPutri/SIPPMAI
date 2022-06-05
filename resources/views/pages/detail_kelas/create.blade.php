@extends('layouts.master')
@section('title', 'Tambah Mahasiswa')
@section('section-header')
<div class="section-header">
    <h1>Tambah Mahasiswa</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('kelas') }}">Kelas</a></div>
      <div class="breadcrumb-item"><a href="{{ route('detail_kelas', $id_kelas) }}">Detail Kelas</a></div>
      <div class="breadcrumb-item">Tambah Mahasiswa</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
    <form action="{{ route('submit.detail_kelas') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <form class="needs-validation" novalidate="">
                    <div class="card-body"> 
                        <input type="hidden" name="id_kelas" class="form-control" value="{{ $id_kelas }}">
                        <div class="form-group">
                            <label>Mahasiswa</label>
                            <select name="nim" class="form-control select2" required="">
                                <option value="">Pilih Mahasiswa</option>
                                @foreach($mahasiswa as $item)
                                    <option value="{{ $item->nim }}">
                                        {{ $item->nim }} - {{ $item->nama_mhs }}</option>
                                @endforeach
                            </select>
                        </div>  
                    </div>
                </form>
                <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

