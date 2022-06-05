@extends('layouts.master')
@section('title', 'Edit Dosen')
@section('section-header')
<div class="section-header">
    <h1>Edit Dosen PAI</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Data User</a></div>
      <div class="breadcrumb-item"><a href="{{ route('dosen') }}">Dosen PAI</a></div>
      <div class="breadcrumb-item">Edit</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
    <form action="{{ route('update.dosen', $dosen->nip) }}" method="POST">
        @csrf
        @if (count($errors) > 0)
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
        @endif
        @method('patch')
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card-body"> 
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" name="nip"  
                        @if (old('nip'))
                        value="{{ (old('nip')) }}"
                        @else
                        value="{{ $dosen->nip }}" 
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
                        value="{{ $dosen->emaildosen }}" 
                        @endif
                        class="form-control" required>
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

