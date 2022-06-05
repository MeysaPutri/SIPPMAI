@extends('layouts.master')
@section('title', 'Tambah Kelompok')
@section('section-header')
<div class="section-header">
    <h1>Tambah Kelompok</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('kelompok') }}">Kelompok</a></div>
      <div class="breadcrumb-item">Tambah</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
    <form action="{{ route('submit.kelompok') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <form class="needs-validation" novalidate="">
                    <div class="card-body"> 
                        <div class="form-group">
                            <label>Periode</label>
                            <select name="id_periode" class="form-control" required="">
                            <option value="">Pilih Periode</option>
                            @foreach ($periode as $item)
                                <option value="{{$item->id_periode}}">
                                    {{$item->periode}}
                                </option>
                            @endforeach
                            </select>
                        </div>                        
                        <div class="form-group"> 
                            <label>Nama Kelompok</label>
                            <input type="text" name="nama_kel" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>Mentor</label>
                            <select name="nim[]" class="form-control select2" multiple required="">
                            <option value="">Pilih Mentor</option>
                            @foreach ($mentor as $item)
                                <option value="{{$item->nim}}">
                                    {{$item->nim}} - {{$item->nama_mhs}}
                                </option>
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

