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
    <form action="{{ route('update.dosen', $dosen->id_dosen) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card-body"> 
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" name="nip_nim"  
                        @if (old('nip_nim'))
                        value="{{ (old('nip_nim')) }}"
                        @else
                        value="{{ $dosen->nip_nim }}" 
                        @endif
                        class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama_dosen"  
                        @if (old('nama_dosen'))
                        value="{{ (old('nama_dosen')) }}"
                        @else
                        value="{{ $dosen->nama_dosen }}" 
                        @endif
                        class="form-control">
                    </div>
                    <div class="form-group">
                        <label>No.HP</label>
                        <input type="text" name="no_hp"  
                        @if (old('no_hp'))
                        value="{{ (old('no_hp')) }}"
                        @else
                        value="{{ $dosen->no_hp }}" 
                        @endif
                        class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email"  
                        @if (old('email'))
                        value="{{ (old('email')) }}"
                        @else
                        value="{{ $dosen->email }}" 
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

