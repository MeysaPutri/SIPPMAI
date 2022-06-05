@extends('layouts.master')
@section('title', 'Amalan Yaumi')
@section('section-header')
<div class="section-header">
    <h1>Amalan Yaumi</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Amalan Yaumi</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
  <div class="row">
    <div class="col-12 col-md-12 col-lg-12">
      <div class="card card-secondary">
        <form action="" method="GET">    
          <form class="needs-validation" novalidate="">
            <div class="card-body"> 
              <table width="100%">
                <tr>
                    <th colspan="3">Pilih periode yang akan Anda lihat</th>
                </tr>
                <th width="70">Periode</th>
                <td width="200">
                  <select name="id_periode" class="form-control select2" onchange="this.form.submit()" required="">
                    <option value="">Pilih Periode</option>                   
                    @foreach($periode as $item)
                      <option value="{{$item->id_periode}}" 
                        @php if(isset($_GET['id_periode'])){
                          if($item->id_periode == $_GET['id_periode']){
                            echo "selected";
                          }
                        } @endphp 
                        @if(session('id_role') != 4)
                          @foreach($selectedPeriode as $data)
                            {{ $data->id_periode== $item->id_periode ? 'selected="selected"':'' }}
                          @endforeach
                        @endif
                        >
                            {{$item->periode}}
                      </option>
                    @endforeach
                    {{-- <script>
                      document.getElementById('id_periode').value = "{{Request::get('id_periode')}}"
                    </script> --}}
                  </select>
                </td>
                <td>
                  <button class="btn btn-outline-dark" type="submit">Lihat</button>
                </td>                
              </table>                   
            </div>
          </form>  
        </form>       
      </div>
      @php
        if(isset($_GET['id_periode'])) :
      @endphp

      <div class="card"> 
      <form action="" method="GET">        
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">                
                <div class="form-group">
                  <label>Mentee</label>
                  <select name="nim" id="nim" class="form-control select2" required="">
                    @php
                      $user = DB::table('users')
                        ->leftJoin('mahasiswas', 'users.nip_nim', '=', 'mahasiswas.nim')
                        ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                        ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                        ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                        ->where('kelompoks.id_periode', Request::get('id_periode'))
                        ->where('users.nip_nim', session('nip_nim'))->first();
                    @endphp
                    @if (session('id_role') == 3)
                      <option value="">Pilih Mentee</option>
                      <option value="{{$user->nim}}" selected="selected" >{{$user->name }}</option>
                    @endif
                    @if (session('id_role') != 3)
                      @php
                        if(session('id_role') == 4){
                          $kel_mentee = DB::table('mahasiswas')
                          ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                          ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                          ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                          ->where('kelompoks.id_periode', Request::get('id_periode'))
                          ->get();
                          
                        }elseif(session('id_role') == 1){
                            $kel_mentor = DB::table('detail_mentors')->where('nim', session('nip_nim'))->first()->nim;
                            $kel_mentee = DB::table('detail_mentees')
                            ->leftJoin('mahasiswas', 'detail_mentees.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', 'kelompoks.id_kel')
                            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                            ->leftJoin('detail_mentors', 'kelompoks.id_kel', '=', 'detail_mentors.id_kel')
                            ->select('detail_mentees.nim', 'mahasiswas.nama_mhs')
                            ->where('kelompoks.id_periode', Request::get('id_periode'))
                            ->where('detail_mentors.nim', $kel_mentor)
                            ->get();
                        }                   
                      @endphp
                      <option value="">Pilih Mentee</option>
                        @foreach ($kel_mentee as $item)
                            <option value="{{$item->nim}}">
                              {{$item->nim}} - {{$item->nama_mhs}}
                            </option>
                        @endforeach
                    @endif
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
                  <script>
                    document.getElementById('id_periode').value = "{{Request::get('id_periode')}}"
                  </script>                   
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
                    <option value="{{$kelas->id_kelas}}">{{Str::upper($kelas->nama_kelas)}}</option>
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
                  <label>Pertemuan</label>
                  <select name="id_pertemuan" id="id_pertemuan" class="form-control select2" required="">
                      <option value="">Pilih Pertemuan</option>
                      @php
                      $pertemuan = DB::table('amalan_yaumis')
                        ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                        ->leftJoin('mahasiswas', 'amalan_yaumis.nim', 'mahasiswas.nim')
                        ->leftJoin('detail_mentees', 'mahasiswas.nim', 'detail_mentees.nim')
                        ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                        ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                        ->where('kelompoks.id_periode', Request::get('id_periode'))
                        ->select('amalan_yaumis.id_pertemuan')
                        ->distinct()
                        ->get();
                      @endphp
                      
                      @for ($i=1;$i<=count($pertemuan)+1;$i++)
                      {
                        echo '<option value="{{$i}}">
                          {{$i}}
                        </option>';
                      }  
                      @endfor  
                  </select>
                </div>
                @php
                  if(isset($_GET['id_pertemuan'])) :
                @endphp
                <script>
                  document.getElementById('id_pertemuan').value = "{{Request::get('id_pertemuan')}}"
                </script>
                  @php
                  endif
                @endphp
              </div>
            </div>            
          </div>
          
          <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" type="submit">Show</button>
          </div>
    </form>
  </div> 
        @php
            endif;
        @endphp 
        @php
            if(isset($_GET['nim'])) :

            $amalan = DB::table('amalan_yaumis')
              ->where('nim', Request::get('nim'))
              ->where('id_pertemuan', Request::get('id_pertemuan'))
              ->orderBy('id_aktifitas', 'asc')
              ->get();
            
            
          
        @endphp
     @if (count($amalan) === 0)
      @if (session('id_role') != 3) 
        <div class="card">
          <div class="card-body">
            <h4 class="text-center">Amalan Yaumi Mentee untuk Pertemuan yang Anda Pilih Belum Diinputkan</h4> 
          </div>
        </div>
      @else
        <div class="card">
          <div class="card-header">
            <table width="100%">
              <th width="100">Pengevaluasi : </th>
              <td width="300">
                @php
                  $mentor = DB::table('detail_mentors')
                    ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                    ->where('mahasiswas.nim', session('nip_nim'))->first();
                  
                  $pengevaluasi = DB::table('amalan_yaumis')
                    ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                    ->leftJoin('mahasiswas', 'amalan_yaumis.nim', '=', 'mahasiswas.nim')
                    ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                    ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                    ->leftjoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                    ->where('amalan_yaumis.id_pertemuan', Request::get('id_pertemuan'))
                    ->where('amalan_yaumis.nim', Request::get('nim'))
                    ->where('kelompoks.id_periode', Request::get('id_periode'))
                    ->select('amalan_yaumis.pengevaluasi')->get();
              @endphp
                <select name="pengevaluasi" id="pengevaluasi" class="form-control select2" required="" style="width: 100%">
                  @if (session('id_role') == 1)
                    <option value="{{$mentor->nama_mhs}}" selected="selected">{{$mentor->nama_mhs}}</option>
                  @endif
                  @if (session('id_role') != 1)
                    @foreach($pengevaluasi as $item)
                      <option value="{{$item->pengevaluasi }}" selected="selected">
                        {{$item->pengevaluasi}}
                      </option>
                    @endforeach                                               
                  @endif
                </select>  
              </td>
              <td>
              </td>                
            </table>  
          </div>
          <div class="card-body">
            <form action="{{ session('id_role') == 1 ? route('store.evaluasi') : route('store.amalan')}}" method="post">
            @csrf
            <input type="hidden" name="nim" value="{{Request::get('nim')}}">        
            <input type="hidden" name="id_periode" value="{{Request::get('id_periode')}}">
            <input type="hidden" name="id_kelas" value="{{Request::get('id_kelas')}}">
            <input type="hidden" name="id_fakultas" value="{{Request::get('id_fakultas')}}">
            <input type="hidden" name="id_kel" value="{{Request::get('id_kel')}}">
            <input type="hidden" name="id_pertemuan" value="{{Request::get('id_pertemuan')}}">
            <div class="table-responsive">
              <table class="table table-striped" >
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Aktifitas</th>
                    <th scope="col">Target Maksimum</th>
                    <th scope="col">Isian</th>
                    @if (session('id_role') == 1 || session('id_role') == 4 || session('id_role') == 3)
                    <th scope="col">Evaluasi</th>
                    @endif
                    <th scope="col" style="display: none;">Pengevaluasi</th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($aktifitas as $key => $isi)
                <input type="hidden" name="id_aktifitas[]" id="" value="{{$isi->id_aktifitas}}">
                  <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>{{$isi->nama_aktifitas}}</td>
                    <td>
                      @if($isi->nama_aktifitas == 'Qiyamullail')
                      7 x/pekan
                      @elseif($isi->nama_aktifitas == 'Shaum nawafil')
                      2 x/pekan
                      @elseif($isi->nama_aktifitas == 'Tilawah quran')
                      10 halaman/hari
                      @elseif($isi->nama_aktifitas == 'Hafalan juz 30')
                      10 ayat/hari
                      @elseif($isi->nama_aktifitas == 'Wirid matsurat')
                      2 x/hari
                      @elseif($isi->nama_aktifitas == 'Shalat dhuha')
                      7 x/pekan
                      @elseif($isi->nama_aktifitas == 'Shalat berjamaah di masjid')
                      35 x/pekan
                      @elseif($isi->nama_aktifitas == 'Membaca buku islami')
                      7 lembar/pekan
                      @elseif($isi->nama_aktifitas == 'Riyadhoh')
                      1 x/pekan
                      @elseif($isi->nama_aktifitas == 'Infak')
                      diceklis (v)
                      @elseif($isi->nama_aktifitas == 'Agenda ukhwah')
                      2 x/bulan
                      @elseif($isi->nama_aktifitas == 'Sholat rawatib')
                      5 x/hari
                      @endif
                    </td>
                    <td>                 
                                       
                      @if($isi->nama_aktifitas == 'Qiyamullail')
                        <input type="number" min="0" max="7" name="isian[]"  id="" class="form-control" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                      @elseif($isi->nama_aktifitas == 'Shaum nawafil')
                        <input type="number" min="0" max="2" name="isian[]" id="" class="form-control" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                      @elseif($isi->nama_aktifitas == 'Tilawah quran')
                        <input type="number" min="0" max="10" name="isian[]"  id="" class="form-control" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                      @elseif($isi->nama_aktifitas == 'Hafalan juz 30')
                        <input type="number" min="0" max="10" name="isian[]"  id="" class="form-control" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                      @elseif($isi->nama_aktifitas == 'Wirid matsurat')
                        <input type="number" min="0" max="2" name="isian[]"  id="" class="form-control" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                      @elseif($isi->nama_aktifitas == 'Shalat dhuha')
                        <input type="number" min="0" max="7" name="isian[]"  id="" class="form-control" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                      @elseif($isi->nama_aktifitas == 'Shalat berjamaah di masjid')
                        <input type="number" min="0" max="35" name="isian[]"  id="" class="form-control" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                      @elseif($isi->nama_aktifitas == 'Membaca buku islami')
                        <input type="number" min="0" max="7" name="isian[]"  id="" class="form-control" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                      @elseif($isi->nama_aktifitas == 'Riyadhoh')
                        <input type="number" min="0" max="1" name="isian[]"  id="" class="form-control" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                      @if ($isi->nama_aktifitas == 'Infak') 
                        <select name="isian[]" class="form-control" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                          <option value="">Pilih Infak</option>
                              <option value="1">Ada</option>
                              <option value="0">Tidak Ada</option>
                        </select>                     
                      @endif 
                      @elseif($isi->nama_aktifitas == 'Agenda ukhwah')
                        <input type="number" min="0" max="2" name="isian[]"  id="" class="form-control" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                      @elseif($isi->nama_aktifitas == 'Sholat rawatib')
                        <input type="number" min="0" max="5" name="isian[]"  id="" class="form-control" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                      @endif
                    </td>
                    @if (session('id_role') == 1 || session('id_role') == 4 || session('id_role') == 3)
                    <td>
                      <input type="text" name="evaluasi[]" id="" class="form-control" {{session('id_role') == 4 ? 'readonly' : ''}} {{session('id_role') == 3 ? 'readonly' : ''}}>
                    </td>
                    @endif
                    <td style="display: none;">
                      @php
                        $mentor = DB::table('detail_mentors')
                          ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                          ->where('mahasiswas.nim', session('nip_nim'))->first();
                        
                        $pengevaluasi = DB::table('amalan_yaumis')
                          ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                          ->leftJoin('mahasiswas', 'amalan_yaumis.nim', '=', 'mahasiswas.nim')
                          ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                          ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                          ->leftjoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                          ->where('amalan_yaumis.id_pertemuan', Request::get('id_pertemuan'))
                          ->where('amalan_yaumis.nim', Request::get('nim'))
                          ->where('kelompoks.id_periode', Request::get('id_periode'))
                          ->select('amalan_yaumis.pengevaluasi')->get();
                      @endphp
                      <select name="pengevaluasi" id="pengevaluasi" class="form-control select2" required="" style="width: 100%">
                        @if (session('id_role') == 1)
                          <option value="{{$mentor->nama_mhs}}" selected="selected">{{$mentor->nama_mhs}}</option>
                        @endif
                        @if (session('id_role') != 1)
                          @foreach($pengevaluasi as $item)
                            <option value="{{$item->pengevaluasi }}" selected="selected">
                              {{$item->pengevaluasi}}
                            </option>
                          @endforeach                                               
                        @endif
                      </select>  
                    </td>
                  </tr>
                @endforeach
                <tr>
                  @if (session('id_role') != 4)
                    @if (session('id_role') != 1)
                    <td colspan="4">
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-sm float-right">Save</button>
                      </div>
                    </td>
                    @endif
                    @if (session('id_role') == 1)
                    <td colspan="5">
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-sm float-right">Save Evaluasi</button>
                      </div>
                    </td>
                    @endif
                  @endif
                </tr>           
                </tbody>          
              </table>
            </form>
          </div>
        </div> 
      @endif
    @else
    <div class="card">
      <div class="card-body">
        <div class="card-header">
          <table width="100%">
            <th width="100">Pengevaluasi : </th>
            <td width="300">
              @php
                $mentor = DB::table('detail_mentors')
                  ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                  ->where('mahasiswas.nim', session('nip_nim'))->first();
                
                $pengevaluasi = DB::table('amalan_yaumis')
                  ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                  ->leftJoin('mahasiswas', 'amalan_yaumis.nim', '=', 'mahasiswas.nim')
                  ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                  ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                  ->leftjoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                  ->where('amalan_yaumis.id_pertemuan', Request::get('id_pertemuan'))
                  ->where('amalan_yaumis.nim', Request::get('nim'))
                  ->where('kelompoks.id_periode', Request::get('id_periode'))
                  ->select('amalan_yaumis.pengevaluasi')->get();
            @endphp
              <select name="pengevaluasi" id="pengevaluasi" class="form-control select2" required="" style="width: 100%">
                @if (session('id_role') == 1)
                  <option value="{{$mentor->nama_mhs}}" selected="selected">{{$mentor->nama_mhs}}</option>
                @endif
                @if (session('id_role') != 1)
                  @foreach($pengevaluasi as $item)
                    <option value="{{$item->pengevaluasi }}" selected="selected">
                      {{$item->pengevaluasi}}
                    </option>
                  @endforeach                                               
                @endif
              </select>  
            </td>
            <td>
            </td>                
          </table> 
        </div>
        <form action="{{session('id_role') == 1 ? route('store.evaluasi') : route('store.amalan')}}" method="post">
        @csrf
        <input type="hidden" name="nim" value="{{Request::get('nim')}}">        
        <input type="hidden" name="id_periode" value="{{Request::get('id_periode')}}">
        <input type="hidden" name="id_kelas" value="{{Request::get('id_kelas')}}">
        <input type="hidden" name="id_fakultas" value="{{Request::get('id_fakultas')}}">
        <input type="hidden" name="id_kel" value="{{Request::get('id_kel')}}">
        <input type="hidden" name="id_pertemuan" value="{{Request::get('id_pertemuan')}}">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Aktifitas</th>
                <th scope="col">Target Maksimum</th>
                <th scope="col">Isian</th>
                @if (session('id_role') == 1 || session('id_role') == 4 || session('id_role') == 3)
                <th scope="col" >Evaluasi</th>
                @endif
                @if (session('id_role') == 2)
                <th scope="col" style="display: none;">Pengevaluasi</th>
                @endif
              </tr>
            </thead>
            <tbody>
            @foreach ($aktifitas as $key => $isi)
            <input type="hidden" name="id_aktifitas[]" id="" value="{{$isi->id_aktifitas}}">
              <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$isi->nama_aktifitas}}</td>
                <td>
                  @if($isi->nama_aktifitas == 'Qiyamullail')
                  7 x/pekan
                  @elseif($isi->nama_aktifitas == 'Shaum nawafil')
                  2 x/pekan
                  @elseif($isi->nama_aktifitas == 'Tilawah quran')
                  10 halaman/hari
                  @elseif($isi->nama_aktifitas == 'Hafalan juz 30')
                  10 ayat/hari
                  @elseif($isi->nama_aktifitas == 'Wirid matsurat')
                  2 x/hari
                  @elseif($isi->nama_aktifitas == 'Shalat dhuha')
                  7 x/pekan
                  @elseif($isi->nama_aktifitas == 'Shalat berjamaah di masjid')
                  35 x/pekan
                  @elseif($isi->nama_aktifitas == 'Membaca buku islami')
                  7 lembar/pekan
                  @elseif($isi->nama_aktifitas == 'Riyadhoh')
                  1 x/pekan
                  @elseif($isi->nama_aktifitas == 'Infak')
                  diceklis (v)
                  @elseif($isi->nama_aktifitas == 'Agenda ukhwah')
                  2 x/bulan
                  @elseif($isi->nama_aktifitas == 'Sholat rawatib')
                  5 x/hari
                  @endif
                </td>
                <td>             
                      
                @if($isi->nama_aktifitas == 'Qiyamullail')
                  <input type="number" min="0" max="7"  name="isian[]"  id="isian[]" class="form-control" value="@if ($amalan[$key]->id_aktifitas==1){{$amalan[$key]->isian}} 
                  @endif" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">   
                  <script>
                    document.getElementsByName('isian[]')[0].value ="{{ $amalan[0]->isian }}"
                  </script>                             
                @elseif($isi->nama_aktifitas == 'Shaum nawafil')
                  <input type="number" min="0" max="2"  name="isian[]"  id="isian[]" class="form-control" value="@if ($amalan[$key]->id_aktifitas==2){{$amalan[$key]->isian}}
                  @endif" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                  <script>
                    document.getElementsByName('isian[]')[1].value ="{{ $amalan[1]->isian }}"
                  </script>    
                @elseif($isi->nama_aktifitas == 'Tilawah quran')
                  <input type="number" min="0" max="10"  name="isian[]"  id="isian[]" class="form-control" value="@if ($amalan[$key]->id_aktifitas==3){{$amalan[$key]->isian}}
                  @endif" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                  <script>
                    document.getElementsByName('isian[]')[2].value ="{{ $amalan[2]->isian }}"
                  </script> 
                @elseif($isi->nama_aktifitas == 'Hafalan juz 30')
                  <input type="number" min="0" max="10"  name="isian[]"  id="isian[]" class="form-control" value="@if ($amalan[$key]->id_aktifitas==4){{$amalan[$key]->isian}}
                  @endif" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                  <script>
                    document.getElementsByName('isian[]')[3].value ="{{ $amalan[3]->isian }}"
                  </script> 
                @elseif($isi->nama_aktifitas == 'Wirid matsurat')
                  <input type="number" min="0" max="2"  name="isian[]"  id="isian[]" class="form-control" value="@if ($amalan[$key]->id_aktifitas==5){{$amalan[$key]->isian}}
                  @endif" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                  <script>
                    document.getElementsByName('isian[]')[4].value ="{{ $amalan[4]->isian }}"
                  </script>  
                @elseif($isi->nama_aktifitas == 'Shalat dhuha')
                  <input type="number" min="0" max="7"  name="isian[]"  id="isian[]" class="form-control" value="@if ($amalan[$key]->id_aktifitas==6){{$amalan[$key]->isian}}
                  @endif" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                  <script>
                    document.getElementsByName('isian[]')[5].value ="{{ $amalan[5]->isian }}"
                  </script> 
                @elseif($isi->nama_aktifitas == 'Shalat berjamaah di masjid')
                  <input type="number" min="0" max="35"  name="isian[]"  id="isian[]" class="form-control" value="@if ($amalan[$key]->id_aktifitas==7){{$amalan[$key]->isian}}
                  @endif" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                  <script>
                    document.getElementsByName('isian[]')[6].value ="{{ $amalan[6]->isian }}"
                  </script> 
                @elseif($isi->nama_aktifitas == 'Membaca buku islami')
                  <input type="number" min="0" max="7"  name="isian[]"  id="isian[]" class="form-control" value="@if ($amalan[$key]->id_aktifitas==8){{$amalan[$key]->isian}}
                  @endif" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                  <script>
                    document.getElementsByName('isian[]')[7].value ="{{ $amalan[7]->isian }}"
                  </script> 
                @elseif($isi->nama_aktifitas == 'Riyadhoh')
                  <input type="number" min="0" max="1"  name="isian[]"  id="isian[]" class="form-control" value="@if ($amalan[$key]->id_aktifitas==9){{$amalan[$key]->isian}}
                  @endif" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                  <script>
                    document.getElementsByName('isian[]')[8].value ="{{ $amalan[8]->isian }}"
                  </script> 
                @elseif ($isi->nama_aktifitas == 'Infak') 
                  {{-- <input type="checkbox" name="isian[]" id="isian[]" value="1" @if ($amalan[$key]->id_aktifitas==10)
                  @php
                    echo  $amalan[$key]->isian == 1 ? 'checked' : '';
                  @endphp                  
                  @endif {{session('id_role') == 1 ? 'disabled' : ''}} {{session('id_role') == 4 ? 'disabled' : ''}}> Ada
                  <input type="checkbox" name="isian[]" id="" value="0" @if ($amalan[$key]->id_aktifitas==10)
                  @php
                    echo  $amalan[$key]->isian == 0 ? 'checked' : '';
                  @endphp
                  @endif {{session('id_role') == 1 ? 'disabled' : ''}} {{session('id_role') == 4 ? 'disabled' : ''}}> Tidak Ada  --}}
                  <select name="isian[]" class="form-control" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                    <option value="">Pilih Infak</option>
                        <option value="1">Ada</option>
                        <option value="0">Tidak Ada</option>
                  </select>
                  <script>
                    document.getElementsByName('isian[]')[9].value ="{{ $amalan[9]->isian }}"
                  </script>  
                @elseif($isi->nama_aktifitas == 'Agenda ukhwah')
                  <input type="number" min="0" max="2"  name="isian[]"  id="isian[]" class="form-control" value="@if ($amalan[$key]->id_aktifitas==11){{$amalan[$key]->isian}}
                  @endif" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                  <script>
                    document.getElementsByName('isian[]')[10].value ="{{ $amalan[10]->isian }}"
                  </script> 
                @elseif($isi->nama_aktifitas == 'Sholat rawatib')
                  <input type="number" min="0" max="5"  name="isian[]"  id="isian[]" class="form-control" value="@if ($amalan[$key]->id_aktifitas==12){{$amalan[$key]->isian}}
                  @endif" {{session('id_role') == 1 ? 'readonly' : ''}} {{session('id_role') == 4 ? 'readonly' : ''}} required="">
                  <script>
                    document.getElementsByName('isian[]')[11].value ="{{ $amalan[11]->isian }}"
                    
                  </script> 
                @endif
                </td>
                @if (session('id_role') == 1 || session('id_role') == 4 || session('id_role') == 3)
                  <td>
                    <input type="text" name="evaluasi[]" id="" class="form-control" value="{{$amalan[$key]->evaluasi}}" {{session('id_role') == 4 ? 'readonly' : ''}} {{session('id_role') == 3 ? 'readonly' : ''}} required="">
                  </td>
                @endif
                <td style="display: none;">
                  @php
                    $mentor = DB::table('detail_mentors')
                      ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                      ->where('mahasiswas.nim', session('nip_nim'))->first();
                    
                    $pengevaluasi = DB::table('amalan_yaumis')
                      ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                      ->leftJoin('mahasiswas', 'amalan_yaumis.nim', '=', 'mahasiswas.nim')
                      ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                      ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                      ->leftjoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                      ->where('amalan_yaumis.id_pertemuan', Request::get('id_pertemuan'))
                      ->where('amalan_yaumis.nim', Request::get('nim'))
                      ->where('kelompoks.id_periode', Request::get('id_periode'))
                      ->select('amalan_yaumis.pengevaluasi')->get();
                  @endphp
                  <select name="pengevaluasi" id="pengevaluasi" class="form-control select2" required="" style="width: 100%">
                    @if (session('id_role') == 1)
                      <option value="{{$mentor->nama_mhs}}" selected="selected">{{$mentor->nama_mhs}}</option>
                    @endif
                    @if (session('id_role') != 1)
                      @foreach($pengevaluasi as $item)
                        <option value="{{$item->pengevaluasi }}" selected="selected">
                          {{$item->pengevaluasi}}
                        </option>
                      @endforeach                                               
                    @endif
                  </select>
                </td>
              </tr>
            @endforeach
              <tr>
              @if (session('id_role') != 4)
                @if (session('id_role') != 1)
                <td colspan="4">
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm float-right">Save</button>
                  </div>
                </td>
                @endif
                @if (session('id_role') == 1)
                <td colspan="5">
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm float-right">Save Evaluasi</button>
                  </div>
                </td>
                @endif
              @endif
            </tr>
            </tbody>
          </table>
        </form>
      </div>
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

