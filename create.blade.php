@extends('layouts.master')
@section('title', 'Kuisioner SCM')
@section('section-header')
<div class="section-header">
    <h1>Kuisioner SCM</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Kuisioner SCM</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
  <form action="{{ route('submit.scm') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <form class="needs-validation" novalidate="">
              {{-- menampilkan error validasi --}}
              @if (count($errors) > 0)
              <div class="alert alert-danger alert-dismissible show fade">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
              @endif
              @php
                  $cek_scm = DB::table('scms')
                  ->where('nim', session('nip_nim'))
                  ->first();
              @endphp
              @if ($cek_scm != null)
              <div class="card">
                <div class="card-body">
                  <h4 class="text-center">Maaf, Anda telah mengisi kuisioner :)</h4> 
                </div>
              </div>
              @else
              <div class="card-body">
                @php
                 $scm = DB::table('users')
                  ->where('nip_nim', session('nip_nim'))->get();                    
                @endphp
                @foreach($scm as $item)
                <input type="hidden" name="nim" value="{{ $item->nip_nim}}">  
                @endforeach      
                <div class="section-title">Apakah Anda bersedia mengikuti kegiatan Suplemen Calon Mentor (SCM)?</div>
                <div class="form-group">
                  <label>Apakah Anda bersedia mengikuti kegiatan Suplemen Calon Mentor (SCM)?</label>
                  <select name="sedia" id="test" name="form_select" class="form-control" required="" onchange="showDiv('hidden_div', this)">
                    <option value="">Pilih pernyataan</option>
                    <option value="1">Ya, bersedia</option>
                    <option value="0">Tidak bersedia</option>
                 </select>
                </div> 
                <div class="form-group" id="hidden_div">
                  <label style="color:red">Sertakan alasan mengapa anda tidak bersedia</label>                     
                  <textarea type="text" name="alasan" id="alasan" class="form-control" ></textarea>         
                </div>                
              </div>
              <div class="card-footer text-right">
                  <button class="btn btn-primary mr-1" name="submit" type="submit">Submit</button>
              </div>
              @endif
            </form>           
          </div>
      </div>
    </form>
</div>

@push('after-scripts')
<script>
  function showDiv(divId, element){
      document.getElementById(divId).style.display = element.value == 0 ?  'block' : 'none';
  }
</script>
@endpush
@endsection

