@extends('layouts.master')
@section('title', 'Edit Kelas')
@section('section-header')
<div class="section-header">
    <h1>Edit Kelas</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('kelas') }}">Kelas</a></div>
      <div class="breadcrumb-item">Edit</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
    <form action="{{ route('update.kelas', $kelas->id_kelas) }}" method="POST">
        @csrf       
        @method('patch')
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
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
                        <label>Nama Kelas</label>
                        <input type="text" name="nama_kelas"  
                        @if (old('nama_kelas'))
                        value="{{ (old('nama_kelas')) }}"
                        @else
                        value="{{ $kelas->nama_kelas }}" 
                        @endif
                        class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Jumlah SKS</label>
                        <select name="sks" class="form-control" required="">
                            <option value="">Pilih Jumlah SKS</option>
                                <option value="2 sks">2 sks</option>
                                <option value="3 sks">3 sks</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Dosen</label>
                        <select name="nip" class="form-control" required="">
                            <option value="">Pilih Dosen</option>
                            @foreach ($dosen as $item)
                                <option value="{{$item->nip}}">
                                    {{$item->nama_dosen}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    document.getElementsByName('nip')[0].value ="{{ $kelas->nip}}"
    document.getElementsByName('id_periode')[0].value ="{{ $kelas->id_periode}}"
    document.getElementsByName('sks')[0].value ="{{ $kelas->sks}}"
</script>
@endsection

