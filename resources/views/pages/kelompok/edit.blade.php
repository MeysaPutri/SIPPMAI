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
                        class="form-control" required="">
                    </div>
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
                        <label>Mentor</label>
                        <select name="nim[]" class="form-control select2" multiple required="">
                          <option value="">Pilih Mentor</option>
                          @foreach ($mentor as $item)
                            @if (in_array($item->nim, $itemMentor))
                                <option value="{{$item->nim}}" selected="true">
                                    {{$item->nim}} - {{$item->nama_mhs}}
                                </option>
                            @else
                                <option value="{{$item->nim}}">
                                    {{$item->nim}} - {{$item->nama_mhs}}
                                </option>
                            @endif                              
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
      document.getElementsByName('id_periode')[0].value ="{{ $kelompok->id_periode}}"
</script>
@endsection

