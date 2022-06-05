@extends('layouts.master')
@section('title', 'Tambah Nilai')
@section('section-header')
<div class="section-header">
    <h1>Tambah Nilai Mentoring</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('nilai') }}">Nilai Mentoring</a></div>
      <div class="breadcrumb-item">Tambah</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">             
            <form action="" method="GET">
              <div class="card-body">
                <div class="row">                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Mentee</label>
                        <select name="nim" id="nim" class="form-control select2" required="" style="width: 100%">
                            <option value="">Pilih Mentee</option>
                            @foreach ($mentee as $item)
                                <option value="{{$item->nim}}">
                                  {{$item->nim}} - {{$item->nama_mhs}}
                                </option>
                            @endforeach
                        </select> 
                        <script>
                          document.getElementById('nim').value = "{{Request::get('nim')}}"
                        </script>                 
                    </div> 
                  </div>                    
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Periode</label>
                      @php
                      if(isset($_GET['nim'])){
                        $periode = DB::table('periodes')
                          ->where('periodes.id_periode', Request::get('id_periode'))->first();
                      }
                      @endphp
                      <select name="id_periode" id="id_periode" class="form-control select2" required="" style="width: 100%">
                        @isset($_GET['nim'])
                            <option value="{{$periode->id_periode}}">{{Str::upper($periode->periode)}}</option>
                        @endisset
                      </select>                  
                    </div>
                  </div>              
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Fakultas</label>
                      @php
                      if(isset($_GET['nim'])){
                        $fakultas = DB::table('fakultas')
                          ->where('fakultas.id_fakultas', Request::get('id_fakultas'))->first();
                      }
                      @endphp
                      <select name="id_fakultas" id="id_fakultas" class="form-control select2" required="" style="width: 100%">
                        @isset($_GET['nim'])
                            <option value="{{$fakultas->id_fakultas}}">{{Str::upper($fakultas->nama_fakultas)}}</option>
                        @endisset
                      </select>                  
                    </div>
                  </div>  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Kelas</label>
                      @php
                      if(isset($_GET['nim'])){
                        $kelas = DB::table('kelas')
                          ->where('kelas.id_kelas', Request::get('id_kelas'))->first();
                      }
                      @endphp
                      <select name="id_kelas" id="id_kelas" class="form-control select2" required="" style="width: 100%">
                        @isset($_GET['nim'])
                        <option value="{{$kelas->id_kelas}}">{{Str::upper($kelas->nama_kelas)}} - {{Str::upper($kelas->sks)}}</option>
                        @endisset
                      </select>                  
                    </div>
                  </div>                                                  
                </div>
                <div class="row">                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Kelompok</label>
                      @php
                      if(isset($_GET['nim'])){
                        $kelompok = DB::table('kelompoks')
                          ->where('kelompoks.id_kel', Request::get('id_kel'))->first();
                      }
                      @endphp
                      <select name="id_kel" id="id_kel" class="form-control select2" required="" style="width: 100%">
                        @isset($_GET['nim'])
                        <option value="{{$kelompok->id_kel}}">{{Str::upper($kelompok->nama_kel)}}</option>
                        @endisset
                      </select>                  
                    </div>
                  </div>  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Penilai</label>
                      @php
                        $mentor = DB::table('detail_mentors')
                          ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                          ->where('mahasiswas.nim', session('nip_nim'))->first();
                      @endphp
                      <select name="penilai" id="penilai" class="form-control select2" required="" style="width: 100%">
                        <option value="{{$mentor->nama_mhs}}">{{Str::upper($mentor->nama_mhs)}}</option>
                      </select>                  
                    </div>
                  </div>
                </div>                
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-primary mr-1" type="submit">Show</button>
              </div>
            </form>
          </div>
          @php
            if(isset($_GET['nim'])) :
          @endphp
          @php
              $cek_nilai = DB::table('nilai_mentorings')
              ->where('nim', Request::get('nim'))
              ->first();
          @endphp
          @if ($cek_nilai != null)
          <div class="card">
            <div class="card-body">
              <h4 class="text-center">Nilai untuk Mentee yang Anda Pilih Sudah Diinputkan</h4> 
            </div>
          </div>
          @else
          <div class="card">            
           
            <form action="{{route('submit.nilai')}}" method="POST">
              @csrf
              <input type="hidden" name="nim" value="{{Request::get('nim')}}">
              <input type="hidden" name="id_periode" value="{{Request::get('id_periode')}}">
              <input type="hidden" name="id_kelas" value="{{Request::get('id_kelas')}}">
              <input type="hidden" name="id_fakultas" value="{{Request::get('id_fakultas')}}">
              <input type="hidden" name="id_kel" value="{{Request::get('id_kel')}}">
              <input type="hidden" name="penilai" value="{{Request::get('penilai')}}">
            <div class="card-body">
              <div class="section-title mt-0">Kehadiran (20%)</div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Hadir</label>
                    <input type="number" min="0" max="9" name="hadir" class="form-control" required=""  value="" >  
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Izin</label>
                    <input type="number" min="0" max="9" name="izin" class="form-control" required=""  value="" >  
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Alfa</label>
                    <input type="number" min="0" max="9" name="alfa" class="form-control" required=""  value="" >  
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Ujian Praktek</label>
                    <select name="pertemuan_ujian" id="pertemuan_ujian" onchange="showDiv('hidden_div', this)" class="form-control select2" required="">
                      <option value="">Pilih Kehadiran</option>
                        <option value="1">Ada</option>
                        <option value="0">Tidak ada</option>
                    </select>                  
                  </div>
                </div>
              </div>
              <div id="hidden_div">
                <hr />
                <div class="section-title mt-0">Nilai Pendalaman Materi (20%)</div>
                <div class="row">
                  <div class="col-12 col-md-6 col-lg-6">
                    <div class="form-group">
                      <input type="number" min="0" max="100" name="npendalaman_materi" class="form-control" >                  
                    </div>
                  </div>
                </div>
                <hr />    
                <div class="section-title mt-0">Nilai Ujian Praktek BBQ (25%)</div>
                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label>Baca Al-Quran</label>
                      <input type="number" min="0" max="100" name="baca_alquran" class="form-control" >                  
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label>Hafalan</label>
                      <input type="number" min="0" max="100" name="hafalan" class="form-control">
                    </div>
                  </div>
                </div> 
                <hr />    
                <div class="section-title mt-0">Nilai Ujian Praktek Ibadah (25%)</div>
                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label>Wudu</label>
                      <input type="number" min="0" max="100" name="wudu" class="form-control">                  
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label>Shalat</label>
                      <input type="number" min="0" max="100" name="shalat" class="form-control">
                    </div>
                  </div>
                </div>                  
              </div>
              <hr />
              <div class="section-title mt-0">Akhlak (10%)</div>
              <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <input type="number" min="0" max="100" name="akhlak" required="" class="form-control">                  
                  </div> 
                </div>
              </div> 
                                   
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary mr-1" type="submit">Hitung</button>
            </div>
          </form>
        </div>
          @endif         
          @php
            endif;
          @endphp
        </div>
      </div>
</div>
@push('page-scripts')
<script>
  function showDiv(divId, element)
{
    document.getElementById(divId).style.display = element.value == 1 ?  'block' : 'none';
}
</script>
  <script>
    $(document).ready(function () {
        $('#nim').change(function(e){
          $('#id_periode').html('');
          $('#id_fakultas').html('');
          $('#id_kelas').html('');
          $('#id_kel').html('');
          e.preventDefault()
          var nim = $(this).val();
          if(nim == ''){
            alert('Pilih mentee terlebih dahulu')
          }else{
            $.ajax({
              type: "POST",
              url: "{{route('api_mentee.nilai')}}",
              data: {
                _token: '{{csrf_token()}}',
                nim:nim
              },
              //   headers: {
              //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              // },
              dataType: "json",
              success: function (res) {
                console.log(res)
                if(res.pesan == 'ok'){
                  var periode =  `<option value='`+res.periode.id_periode+`'>`+ res.periode.periode.toUpperCase() +`</option>`;
                  var fakultas =  `<option value='`+res.fakultas.id_fakultas+`'>`+ res.fakultas.nama_fakultas.toUpperCase() +`</option>`;
                  var kelas =  `<option value='`+res.kelas.id_kelas+`'>`+ res.kelas.nama_kelas.toUpperCase() +`</option>`;
                  var kelompok =  `<option value='`+res.kelompok.id_kel+`'>`+ res.kelompok.nama_kel.toUpperCase() +`</option>`;
                  $('#id_periode').append(periode);
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
@endpush
@endsection

