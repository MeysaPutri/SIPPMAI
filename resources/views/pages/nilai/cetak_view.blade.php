@extends('layouts.master')
@section('title', 'Cetak Nilai')
@section('section-header')
<div class="section-header">
    <h1>Cetak Nilai Mentoring</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item active"><a href="{{ route('nilai') }}">Nilai Mentoring</a></div>
      <div class="breadcrumb-item a">Cetak Nilai Mentoring</div>
    </div>
</div>    
@endsection
@section('content')

<div class="section-body">
    <div class="row"> 
      @if (count($errors) > 0)
              <div class="alert alert-danger alert-dismissible show fade">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
      @endif
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                  <form action="{{route('cetak.nilai.store')}}" method="post">
                      @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                              <label>Berdasarkan</label>
                                <select name="key" id="key" class="form-control select2" required="" style="width: 100%">
                                      <option value="">Pilih</option>
                                      <option value="keseluruhan">Keseluruhan</option>
                                      <option value="kelas">Satu Kelas</option>
                                      <option value="fakultas">Satu Fakultas</option>
                                      <option value="kelompok">Satu Kelompok</option>
                                </select>                  
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Periode</label>
                                <select name="id_periode" id="id_periode" class="form-control select2" required="" style="width: 100%">
                                      <option value="">Pilih Periode</option>
                                      @foreach ($periode as $item)
                                      <option value="{{$item->id_periode}}">{{$item->periode}}</option>
                                      @endforeach
                                </select>                  
                            </div>
                          </div>
                          <div class="col-md-4" id="filter1" hidden>
                            <div class="form-group">
                              <label>Filter</label>
                                <select name="id_kelas" id="id_kelas" class="form-control select2" required="" style="width: 100%" disabled>
                                  <option value="">Pilih Filter</option>
                                </select>                  
                            </div>
                          </div>
                          <div class="col-md-4" id="filter2" hidden>
                            <div class="form-group">
                              <label>Filter</label>
                                <select name="id_fakultas" id="id_fakultas" class="form-control select2" required="" style="width: 100%" disabled>
                                  <option value="">Pilih Filter</option>
                                </select>                  
                            </div>
                          </div>
                          <div class="col-md-4" id="filter3" hidden>
                            <div class="form-group">
                              <label>Filter</label>
                                <select name="id_kel" id="id_kel" class="form-control select2" required="" style="width: 100%" disabled>
                                  <option value="">Pilih Filter</option>
                                </select>                  
                            </div>
                          </div>
                          <div class="col-md-4" id="filter4" hidden>
                            <div class="form-group">
                              <label>Filter</label>
                                <select name="semua" id="semua" class="form-control select2" required="" style="width: 100%" disabled>
                                  <option value="">Pilih Filter</option>
                                  <option value="semuakelas">Semua Kelas</option>
                                  <option value="semuafakultas">Semua Fakultas</option>
                                  <option value="semuakelompok">Semua Kelompok</option>
                                </select>                  
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">Cetak Nilai Mentoring</button>     
                            </div>
                          </div>
                    </div>
                </form>
              </div>
            </div>     
        </div>
    </div>
</div>

@push('after-scripts')
<script>
  $(document).ready(function () {
      $('#id_periode').change(function(e){
        $('#id_fakultas').html('');
        $('#id_kelas').html('');
        $('#id_kel').html('');
        e.preventDefault()
        var id_periode = $(this).val();
        if(id_periode == ''){
          alert('Pilih periode terlebih dahulu')
        }else{
          $.ajax({
            type: "POST",
            url: "{{route('dropdown.nilai')}}",
            data: {
              _token: '{{csrf_token()}}',
              id_periode:id_periode
              },
            dataType: "json",
            success: function (res) {
              console.log(res) //dimahasiswa gak ada
              if(res.pesan == 'ok'){
                var fakultas = '';
                var f;
                for(f=0;f<res.fakultas.length;f++){
                  fakultas += `<option value='`+res.fakultas[f].id_fakultas+`'>`+ res.fakultas[f].nama_fakultas.toUpperCase() +`</option>`
                }
                var kelas = '';
                var k;
                for(k=0;k<res.kelas.length;k++){
                  kelas += `<option value='`+res.kelas[k].id_kelas+`'>`+ res.kelas[k].nama_kelas.toUpperCase() +`</option>`
                }
                var kelompok = '';
                var l;
                for(l=0;l<res.kelompok.length;l++){
                  kelompok += `<option value='`+res.kelompok[l].id_kel+`'>`+ res.kelompok[l].nama_kel.toUpperCase() +`</option>`
                }
                $('#id_fakultas').append(fakultas);
                $('#id_kelas').append(kelas);
                $('#id_kel').append(kelompok);
              }
            }
          });
        }
      })
    });
</script>
<script>
    $('#key').change(function(e){
        $('#filter1').attr('hidden','')
        $('#filter2').attr('hidden','')
        $('#filter3').attr('hidden','')
        $('#filter4').attr('hidden','')
        e.preventDefault()
        var key = $(this).val();
        if(key == 'kelas'){
            $('#filter1').removeAttr('hidden','')
            $('#id_kelas').removeAttr('disabled','')
        }else if(key == 'fakultas'){
            $('#filter2').removeAttr('hidden','')
            $('#id_fakultas').removeAttr('disabled','')
        }else if(key == 'kelompok'){
            $('#filter3').removeAttr('hidden','')
            $('#id_kel').removeAttr('disabled','')
        }else if(key == 'keseluruhan'){
            $('#filter4').removeAttr('hidden','')
            $('#semua').removeAttr('disabled','')
        }
    })
</script>
@endpush
@endsection

