@extends('layouts.master')
@section('title', 'Edit Nilai')
@section('section-header')
<div class="section-header">
    <h1>Edit Nilai Mentoring</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('nilai') }}">Nilai Mentoring</a></div>
      <div class="breadcrumb-item">Edit</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">             
            <form action="{{route('update.nilai', $nilai->id_nm)}}" method="POST">
              @csrf
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Mentee</label>
                        <select name="nim" id="nim" class="form-control select2" required="" style="width: 100%">
                            <option value="{{$nilai->nim}}">{{$nilai->nama_mhs}}</option>
                        </select>                  
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Periode</label>
                        <select name="id_periode" id="id_periode" class="form-control select2" required="" style="width: 100%">
                            <option value="{{$nilai->id_periode}}">{{$nilai->periode}}</option>
                        </select>                  
                    </div>
                  </div>                  
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Fakultas</label>
                        <select name="id_fakultas" id="id_fakultas" class="form-control select2" required="" style="width: 100%">
                          <option value="{{$nilai->id_fakultas}}">{{$nilai->nama_fakultas}}</option>

                        </select>                  
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Kelas</label>
                        <select name="id_kelas" id="id_kelas" class="form-control select2" required="" style="width: 100%">
                          <option value="{{$nilai->id_kelas}}">{{$nilai->nama_kelas}} - {{ $nilai->sks }}</option>
                        </select>                  
                    </div>
                  </div>                                    
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Kelompok</label>
                        <select name="id_kel" id="id_kel" class="form-control select2" required="" style="width: 100%">
                          <option value="{{$nilai->id_kel}}">{{$nilai->nama_kel}}</option>
                        </select>                  
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Penilai</label>
                        <select name="penilai" id="penilai" class="form-control select2" required="" style="width: 100%">
                        @php
                          $mentor = DB::table('detail_mentors')
                            ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                            ->where('mahasiswas.nim', session('nip_nim'))->first();
                        @endphp
                        <option value="{{$mentor->nama_mhs}}">{{Str::upper($mentor->nama_mhs)}}</option>
                      </select>                  
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="card">              
              <div class="card-body">
                <div class="section-title mt-0">Kehadiran (20%)
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label>Hadir</label>
                        <input type="number" min="0" max="9" name="hadir" class="form-control" required=""  value="{{ $nilai->hadir }}" >  
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label>Izin</label>
                        <input type="number" min="0" max="9" name="izin" class="form-control" required=""  value="{{ $nilai->izin }}" >  
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label>Alfa</label>
                        <input type="number" min="0" max="9" name="alfa" class="form-control" required=""  value="{{ $nilai->alfa }}" >  
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label>Ujian Praktek</label>
                        <select name="pertemuan_ujian" id="pertemuan_ujian" onchange="showDiv('hidden_div', this)" class="form-control select2" required="" value="{{$nilai->pertemuan_ujian}}">
                          <option value="">Pilih Kehadiran</option>
                            <option value="1">Ada</option>
                            <option value="0">Tidak ada</option>
                        </select>                  
                      </div>
                    </div>
                  </div>
                </div>
                <div id="hidden_div">
                  <hr />
                  <div class="section-title mt-0">Nilai Pendalaman Materi (20%)
                    <div class="row">
                      <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                          <input type="text" min="0" max="100" name="npendalaman_materi" class="form-control" value="{{$nilai->npendalaman_materi}}">                  
                        </div>
                      </div>
                    </div> 
                  </div>
                  <hr />   
                  <div class="section-title mt-0">Nilai Ujian Praktek BBQ (25%)
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Baca Al-Quran</label>
                          <input type="text" min="0" max="100" name="baca_alquran" class="form-control" value="{{$nilai->baca_alquran}}">                  
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Hafalan</label>
                          <input type="text" min="0" max="100" name="hafalan" class="form-control" value="{{$nilai->hafalan}}">
                        </div>
                      </div>
                    </div>  
                  </div>   
                  <hr />
                  <div class="section-title mt-0">Nilai Ujian Praktek Ibadah (25%)
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Wudu</label>
                          <input type="text" min="0" max="100" name="wudu" class="form-control" value="{{$nilai->wudu}}">                  
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Shalat</label>
                          <input type="text" min="0" max="100" name="shalat" class="form-control" value="{{$nilai->shalat}}">
                        </div>
                      </div>
                    </div>
                  </div>                  
                </div>  
                <hr />
                <div class="section-title mt-0">Akhlak (10%)
                  <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <input type="text" min="0" max="100" name="akhlak" class="form-control" required="" value="{{$nilai->akhlak}}">                  
                      </div> 
                    </div>
                  </div>    
                </div>                  
              </div>
              <div class="card-footer text-right">
                  <button class="btn btn-primary mr-1" type="submit">Save changes</button>
              </div>
          </div>
        </div>
      </div>
  </form>
</div>
<script>
  document.getElementsByName('pertemuan_ujian')[0].value ="{{ $nilai->pertemuan_ujian}}"
</script>
<script>
  function showDiv(divId, element){
      document.getElementById(divId).style.display = element.value == 1 ?  'block' : 'none';
  }
</script>

@endsection

