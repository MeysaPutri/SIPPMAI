@extends('layouts.master')
@section('title', 'Edit Persetujuan SCM')
@section('section-header')
<div class="section-header">
    <h1>Edit Persetujuan SCM</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Edit Persetujuan SCM</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
  <form action="{{ route('update.scm', $scm->nim) }}" method="POST">
      @csrf
      @method('patch')
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
              <div class="card-body">    
                <div class="section-title">Apakah Anda bersedia mengikuti kegiatan Suplemen Calon Mentor (SCM)?</div>
                <div class="form-group">
                  {{-- <label>Apakah Anda bersedia mengikuti kegiatan Suplemen Calon Mentor (SCM)?</label> --}}
                  <select name="sedia" name="form_select" class="form-control" required="" onchange="showDiv('hidden_div1', this)">
                    <option value="">Pilih pernyataan</option>
                    <option value="1">Ya, bersedia</option>
                    <option value="0">Tidak bersedia</option>
                 </select>
                </div> 
                <div class="form-group" id="hidden_div1">
                  <label style="color:red">Sertakan alasan mengapa anda tidak bersedia</label>                     
                  <textarea type="text" name="alasan" id="alasan"  class="form-control">
                    @if (old('alasan'))
                      {{ (old('alasan')) }}
                    @else
                      {{ $scm->alasan }}
                    @endif
                  </textarea>       
                </div>                
              </div>
              <div class="card-footer text-right">
                  <button class="btn btn-primary mr-1" name="submit" type="submit">Save changes</button>
              </div>
            </form>           
          </div>
      </div>
    </form>
</div>
<script>
  document.getElementsByName('sedia')[0].value ="{{ $scm->sedia}}"
</script>

@push('after-scripts')
<script>
  function showDiv(divId, element){
      document.getElementById(divId).style.display = element.value == 0 ?  'block' : 'none';
  }
</script>
@endpush
@endsection

