@extends('layouts.master')
@section('title', 'Dashboard')
@section('section-header')
<div class="section-header">
    <h1>Dashboard</h1>
</div>    
@endsection
@section('content')
<div class="section-body">
  {{-- <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container">
      <div class="page-header-content pt-4">
        <div class="row align-items-center justify-content-between">
          <div class="col-auto mt-4">
            <h1 class="page-header-title">
              <div class="page-header-icon"></div>
              <?php
                date_default_timezone_set('Asia/Jakarta');
                echo date('l, d-m-Y h:i a');
              ?>
            </h1>
          </div>
        </div> 
      </div>
    </div>
  </header> --}}
  <div class="row">
    <div class="col-12 mb-4">
      <form action="" method="GET"> 
        <div class="hero text-white hero-bg-image hero-bg-parallax" style="background-image: url('assets/img/unsplash/eberhard-grossgasteiger-1207565-unsplash.jpg');">
          <div class="hero-inner">
            <h2>Selamat Datang di Sistem Informasi Penilaian dan Pelaksanaan Mentoring Agama Islam - Universitas Andalas !</h2>
              <br>
              <div class="btn-group">
                <p class="lead">Pada Periode &nbsp;</p>
                <div class="form-group">
                  <select name="id_periode" class="form-control" required=""  onchange="this.form.submit()">
                    <option value="">Pilih Periode</option>
                    @foreach ($periode as $item)
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
                </select>
                </div>
                &nbsp;&nbsp;
                <div class="buttons">
                  <button class="btn btn-lg btn-dark btn-outline-primary">Lihat</button>
                </div>
              </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  @php
      $periode = DB::table('periodes')->max('id_periode');

      $mentee = DB::table('nilai_mentorings') 
        ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
        ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
        ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
        ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
        ->leftJoin('users', 'mahasiswas.nim', '=', 'users.nip_nim')
        ->select('detail_mentees.*', 'periodes.*', 'mahasiswas.*', 'users.*')
        ->where('kelompoks.id_periode', $periode)        
        ->where('users.nip_nim', session('nip_nim'))   
        ->where('nilai_mentorings.hadir', '>=', 6)
        ->select(
          'nilai_mentorings.*',
          'mahasiswas.*',
          'detail_mentees.*',
          'kelompoks.*',
          'periodes.*',
          'users.*'
          )
        ->get();     
  @endphp

@if(session('id_role') ==3 )
    @foreach($mentee as $item)
    <div class="row">
      <div class="col-12 mb-4">
        <div class="hero text-white hero-bg-image hero-bg-parallax" style="background-image: url('assets/img/unsplash/eberhard-grossgasteiger-1207565-unsplash.jpg');">
          <div class="hero align-items-center bg-white text-white">
            <div class="hero-inner text-center">
              <h2 style="color:black">CONGRATULATIONS {{ Str::upper($item->name) }} !</h2>
              <p class="lead" style="color: black">Anda telah memenuhi salah satu kriteria untuk menjadi calon mentor untuk tahun selanjutnya</p>
              <div class="mt-4">
                @php
                  $cek_scm = DB::table('scms')
                  ->where('nim', session('nip_nim'))
                  ->first();
                @endphp
                <a href="
                @if ($cek_scm == null)
                  {{ route('create.scm', $item->nim ) }}
                @else
                  {{ route('persetujuan.scm', $item->nim ) }}
                @endif
                  " class="btn btn-success btn-lg btn-icon icon-left" style="color: black"><i class="fas fa-sign-in-alt"></i> Ketuk untuk info lebih lanjut</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  @endif
  @php
    if(isset($_GET['id_periode'])) :

  @endphp  
  <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="far fa-user"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Mentor</h4>
              </div>
              @php
                  $mentor = DB::table('detail_mentors')
                    ->leftJoin('kelompoks', 'detail_mentors.id_kel', '=', 'kelompoks.id_kel')
                    ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                    ->where('kelompoks.id_periode', Request::get('id_periode'))
                    ->select('detail_mentors.nim')
                    ->count();
              @endphp
              <div class="card-body">
                {{$mentor}}
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
              <i class="far fa-newspaper"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Mentee</h4>
              </div>
              @php
                $mentee = DB::table('detail_mentees')
                  ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                  ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                  ->where('kelompoks.id_periode', Request::get('id_periode'))
                  ->select('detail_mentees.nim')
                  ->count();
              @endphp
              <div class="card-body">
                {{$mentee}}
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="far fa-file"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Kelas</h4>
              </div>
              @php
              $kelas = DB::table('kelas')
                ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                ->where('kelas.id_periode', Request::get('id_periode'))
                ->select('kelas.id_kelas')
                ->count();
              @endphp
              <div class="card-body">
                {{$kelas}}
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-circle"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Kelompok</h4>
              </div>
              @php
                $kelompok = DB::table('kelompoks')
                  ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                  ->select('kelompoks.id_kel')
                  ->where('kelompoks.id_periode', Request::get('id_periode'))
                  ->count();
              @endphp
              <div class="card-body">
                {{$kelompok}}
              </div>
            </div>
          </div>
        </div>
  </div>  
  <div class="row">
    <div class="col-12">
      <div class="card card-danger">
         
          <div class="card-header">
            <h4>Perangkingan Amalan Yaumi Mentee</h4>
            <div class="card-header-action">
              <table width="100%">
                <td>
                  <select name="id_pertemuan" id="id_pertemuan" class="form-control" required="">
                    <option value="">Pilih Pertemuan</option>
                    @php
                    $pertemuan = DB::table('amalan_yaumis')
                      ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                      ->leftJoin('mahasiswas', 'amalan_yaumis.nim', 'mahasiswas.nim')
                      ->leftJoin('detail_mentees', 'mahasiswas.nim', 'detail_mentees.nim')
                      ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                      ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                      ->select('amalan_yaumis.id_pertemuan')
                      ->where('kelompoks.id_periode', Request::get('id_periode'))
                      ->distinct()
                      ->get();
                    @endphp
                    
                    @for ($i=1;$i<=count($pertemuan);$i++)
                    {
                      echo '<option value="{{$i}}">
                        {{$i}}
                      </option>';
                    }  
                    @endfor  
                    <script>
                      document.getElementById('id_pertemuan').value = "{{Request::get('id_pertemuan')}}"
                    </script>
                  </select>
                </td>
                <td>
                  <button onclick="tes()" class="btn btn-lg btn-primary" type="button">Lihat</button>
                </td>  
              </table>            
            </div>
          </div>
          <script>
            function tes()
            {
              var id_temu = $('#id_pertemuan option:selected').val();
              var url = "?id_periode={{Request::get('id_periode')}}&id_pertemuan="+id_temu;
              window.location = url;
            }
          </script>
        
        @php
          if(isset($_GET['id_pertemuan'])) :

        @endphp 
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-12 col-md-4">
              <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active"  id="ql" data-toggle="tab" href="#qiyamullail" role="tab" aria-controls="qiyamullail" aria-selected="true">Qiyamullail</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="sh" data-toggle="tab" href="#shaum" role="tab" aria-controls="shaum" aria-selected="false">Shaum Nawafil</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="tq" data-toggle="tab" href="#tilawah" role="tab" aria-controls="tilawah" aria-selected="false">Tilawah Quran</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="h" data-toggle="tab" href="#hafalan" role="tab" aria-controls="hafalan" aria-selected="false">Hafalan Juz 30</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="wm" data-toggle="tab" href="#wirid" role="tab" aria-controls="wirid" aria-selected="false">Wirid Matsurat</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="sd" data-toggle="tab" href="#dhuha" role="tab" aria-controls="dhuha" aria-selected="false">Shalat Dhuha</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="sbdm" data-toggle="tab" href="#berjamaah" role="tab" aria-controls="berjamaah" aria-selected="false">Shalat Berjamaah Di Masjid</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="mbi" data-toggle="tab" href="#buku" role="tab" aria-controls="buku" aria-selected="false">Membaca Buku Islami</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="r" data-toggle="tab" href="#riyadhoh" role="tab" aria-controls="riyadhoh" aria-selected="false">Riyadhoh</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="au" data-toggle="tab" href="#agenda" role="tab" aria-controls="agenda" aria-selected="false">Agenda ukhuwah</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="sr" data-toggle="tab" href="#rawatib" role="tab" aria-controls="rawatib" aria-selected="false">Shalat Rawatib</a>
                </li>
              </ul>
            </div>
            <div class="col-12 col-sm-12 col-md-8">
              <div class="tab-content no-padding" id="myTab2Content">
                <div class="tab-pane fade show active" id="qiyamullail" role="tabpanel" aria-labelledby="ql">
                  <table cellpadding="7" border="1" width="100%" height="25%" class="text-center" >
                    <thead bgcolor="#F0F1F1">
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama Mentee</th>
                        <th scope="col">Total Qiyamullail (x/pekan)</th>
                        <th scope="col">Nama Kelompok</th>
                        <th scope="col">Nama Mentor</th>
                        <th scope="col">Nama Dosen</th>                          
                      </tr>
                    </thead>
                    <tbody>
                      @php
                          $amalan = DB::table('amalan_yaumis')
                            ->leftJoin('mahasiswas', 'amalan_yaumis.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', 'kelompoks.id_kel')
                            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                            ->leftJoin('aktifitas', 'amalan_yaumis.id_aktifitas', '=', 'aktifitas.id_aktifitas')
                            ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                            ->select(
                                'amalan_yaumis.*',
                                'mahasiswas.*',
                                'detail_mentees.*',
                                'kelompoks.*',
                                'detail_kelas.*',
                                'kelas.*',
                                'dosens.*',
                                'aktifitas.*',
                                'pertemuans.*',
                                'periodes.*'
                            )
                            ->where('aktifitas.id_aktifitas', '1')
                            ->where('kelompoks.id_periode', Request::get('id_periode'))
                            ->where('amalan_yaumis.id_pertemuan', Request::get('id_pertemuan'))
                            ->orderBy('amalan_yaumis.isian', 'DESC')
                            ->limit(5)
                            ->get();
                      @endphp   
                      @foreach ($amalan as $no =>$item)                      
                      <tr>
                        <th scope="row">{{ $no+1 }}</th>
                        <td>{{ $item->nim }}</td>
                        <td>{{ $item->nama_mhs }}</td>                          
                        <td><b>{{ $item->isian }}</b></td>
                        <td>{{ $item->nama_kel }}</td>
                        <td>
                          @php
                            $detail_mentor = DB::table('detail_mentors')                            
                              ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                              ->select('detail_mentors.nim', 'mahasiswas.nama_mhs')
                              ->where('id_kel', $item->id_kel)
                              ->get();
                          @endphp
                          @foreach($detail_mentor as $key => $data)
                            Mentor {{ $key+1 }} : {{ $data->nama_mhs }}
                            <br>
                          @endforeach
                        </td>
                        <td>{{ $item->nama_dosen }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade" id="shaum" role="tabpanel" aria-labelledby="sh">
                  <table cellpadding="7" border="1" width="100%" height="25%" class="text-center" >
                    <thead bgcolor="#F0F1F1">
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama Mentee</th>
                        <th scope="col">Total Shaum Nawafil (x/pekan)</th>
                        <th scope="col">Nama Kelompok</th>
                        <th scope="col">Nama Mentor</th>
                        <th scope="col">Nama Dosen</th>                          
                      </tr>
                    </thead>
                    <tbody>
                      @php
                          $amalan = DB::table('amalan_yaumis')
                            ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                            ->leftJoin('mahasiswas', 'amalan_yaumis.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', 'kelompoks.id_kel')
                            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                            ->leftJoin('aktifitas', 'amalan_yaumis.id_aktifitas', '=', 'aktifitas.id_aktifitas')
                            ->select(
                                'amalan_yaumis.*',
                                'mahasiswas.*',
                                'detail_mentees.*',
                                'kelompoks.*',
                                'detail_kelas.*',
                                'kelas.*',
                                'dosens.*',
                                'aktifitas.*',
                                'pertemuans.*',
                                'periodes.*'
                            )
                            ->where('aktifitas.id_aktifitas', '2')
                            ->where('amalan_yaumis.id_pertemuan', Request::get('id_pertemuan'))
                            ->where('kelompoks.id_periode', Request::get('id_periode'))
                            ->orderBy('amalan_yaumis.isian', 'DESC')
                            ->limit(5)
                            ->get();
                      @endphp   
                      @foreach ($amalan as $no =>$item)                      
                      <tr>
                        <th scope="row">{{ $no+1 }}</th>
                        <td>{{ $item->nim }}</td>
                        <td>{{ $item->nama_mhs }}</td>                          
                        <td><b>{{ $item->isian }}</b></td>
                        <td>{{ $item->nama_kel }}</td>
                        <td>
                          @php
                            $detail_mentor = DB::table('detail_mentors')                            
                              ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                              ->select('detail_mentors.nim', 'mahasiswas.nama_mhs')
                              ->where('id_kel', $item->id_kel)
                              ->get();
                          @endphp
                          @foreach($detail_mentor as $key => $data)
                            Mentor {{ $key+1 }} : {{ $data->nama_mhs }}
                            <br>
                          @endforeach
                        </td>
                        <td>{{ $item->nama_dosen }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade" id="tilawah" role="tabpanel" aria-labelledby="tq">
                  <table cellpadding="7" border="1" width="100%" height="25%" class="text-center" >
                    <thead bgcolor="#F0F1F1">
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama Mentee</th>
                        <th scope="col">Total Tilawah Quran (x/pekan)</th>
                        <th scope="col">Nama Kelompok</th>
                        <th scope="col">Nama Mentor</th>
                        <th scope="col">Nama Dosen</th>                          
                      </tr>
                    </thead>
                    <tbody>
                      @php
                          $amalan = DB::table('amalan_yaumis')
                            ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                            ->leftJoin('mahasiswas', 'amalan_yaumis.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', 'kelompoks.id_kel')
                            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                            ->leftJoin('aktifitas', 'amalan_yaumis.id_aktifitas', '=', 'aktifitas.id_aktifitas')
                            ->select(
                                'amalan_yaumis.*',
                                'mahasiswas.*',
                                'detail_mentees.*',
                                'kelompoks.*',
                                'detail_kelas.*',
                                'kelas.*',
                                'dosens.*',
                                'aktifitas.*',
                                'pertemuans.*',
                                'periodes.*'
                            )
                            ->where('aktifitas.id_aktifitas', '3')
                            ->where('amalan_yaumis.id_pertemuan', Request::get('id_pertemuan'))
                            ->where('kelompoks.id_periode', Request::get('id_periode'))
                            ->orderBy('amalan_yaumis.isian', 'DESC')
                            ->limit(5)
                            ->get();
                      @endphp   
                      @foreach ($amalan as $no =>$item)                      
                      <tr>
                        <th scope="row">{{ $no+1 }}</th>
                        <td>{{ $item->nim }}</td>
                        <td>{{ $item->nama_mhs }}</td>                          
                        <td><b>{{ $item->isian }}</b></td>
                        <td>{{ $item->nama_kel }}</td>
                        <td>
                          @php
                            $detail_mentor = DB::table('detail_mentors')                            
                              ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                              ->select('detail_mentors.nim', 'mahasiswas.nama_mhs')
                              ->where('id_kel', $item->id_kel)
                              ->get();
                          @endphp
                          @foreach($detail_mentor as $key => $data)
                            Mentor {{ $key+1 }} : {{ $data->nama_mhs }}
                            <br>
                          @endforeach
                        </td>
                        <td>{{ $item->nama_dosen }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade" id="hafalan" role="tabpanel" aria-labelledby="h">
                  <table cellpadding="7" border="1" width="100%" height="25%" class="text-center" >
                    <thead bgcolor="#F0F1F1">
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama Mentee</th>
                        <th scope="col">Total Hafalan Juz 30 (x/hari)</th>
                        <th scope="col">Nama Kelompok</th>
                        <th scope="col">Nama Mentor</th>
                        <th scope="col">Nama Dosen</th>                          
                      </tr>
                    </thead>
                    <tbody>
                      @php
                          $amalan = DB::table('amalan_yaumis')
                            ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                            ->leftJoin('mahasiswas', 'amalan_yaumis.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', 'kelompoks.id_kel')
                            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                            ->leftJoin('aktifitas', 'amalan_yaumis.id_aktifitas', '=', 'aktifitas.id_aktifitas')
                            ->select(
                                'amalan_yaumis.*',
                                'mahasiswas.*',
                                'detail_mentees.*',
                                'kelompoks.*',
                                'detail_kelas.*',
                                'kelas.*',
                                'dosens.*',
                                'aktifitas.*',
                                'pertemuans.*',
                                'periodes.*'
                            )
                            ->where('aktifitas.id_aktifitas', '4')
                            ->where('amalan_yaumis.id_pertemuan', Request::get('id_pertemuan'))
                            ->where('kelompoks.id_periode', Request::get('id_periode'))
                            ->orderBy('amalan_yaumis.isian', 'DESC')
                            ->limit(5)
                            ->get();
                      @endphp   
                      @foreach ($amalan as $no =>$item)                      
                      <tr>
                        <th scope="row">{{ $no+1 }}</th>
                        <td>{{ $item->nim }}</td>
                        <td>{{ $item->nama_mhs }}</td>                          
                        <td><b>{{ $item->isian }}</b></td>
                        <td>{{ $item->nama_kel }}</td>
                        <td>
                          @php
                            $detail_mentor = DB::table('detail_mentors')                            
                              ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                              ->select('detail_mentors.nim', 'mahasiswas.nama_mhs')
                              ->where('id_kel', $item->id_kel)
                              ->get();
                          @endphp
                          @foreach($detail_mentor as $key => $data)
                            Mentor {{ $key+1 }} : {{ $data->nama_mhs }}
                            <br>
                          @endforeach
                        </td>
                        <td>{{ $item->nama_dosen }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade" id="wirid" role="tabpanel" aria-labelledby="wm">
                  <table cellpadding="7" border="1" width="100%" height="25%" class="text-center" >
                    <thead bgcolor="#F0F1F1">
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama Mentee</th>
                        <th scope="col">Total Wirid Matsurat (x/pekan)</th>
                        <th scope="col">Nama Kelompok</th>
                        <th scope="col">Nama Mentor</th>
                        <th scope="col">Nama Dosen</th>                          
                      </tr>
                    </thead>
                    <tbody>
                      @php
                          $amalan = DB::table('amalan_yaumis')
                            ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                            ->leftJoin('mahasiswas', 'amalan_yaumis.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', 'kelompoks.id_kel')
                            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                            ->leftJoin('aktifitas', 'amalan_yaumis.id_aktifitas', '=', 'aktifitas.id_aktifitas')
                            ->select(
                                'amalan_yaumis.*',
                                'mahasiswas.*',
                                'detail_mentees.*',
                                'kelompoks.*',
                                'detail_kelas.*',
                                'kelas.*',
                                'dosens.*',
                                'aktifitas.*',
                                'pertemuans.*',
                                'periodes.*'
                            )
                            ->where('aktifitas.id_aktifitas', '5')
                            ->where('amalan_yaumis.id_pertemuan', Request::get('id_pertemuan'))
                            ->where('kelompoks.id_periode', Request::get('id_periode'))
                            ->orderBy('amalan_yaumis.isian', 'DESC')
                            ->limit(5)
                            ->get();
                      @endphp   
                      @foreach ($amalan as $no =>$item)                      
                      <tr>
                        <th scope="row">{{ $no+1 }}</th>
                        <td>{{ $item->nim }}</td>
                        <td>{{ $item->nama_mhs }}</td>                          
                        <td><b>{{ $item->isian }}</b></td>
                        <td>{{ $item->nama_kel }}</td>
                        <td>
                          @php
                            $detail_mentor = DB::table('detail_mentors')                            
                              ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                              ->select('detail_mentors.nim', 'mahasiswas.nama_mhs')
                              ->where('id_kel', $item->id_kel)
                              ->get();
                          @endphp
                          @foreach($detail_mentor as $key => $data)
                            Mentor {{ $key+1 }} : {{ $data->nama_mhs }}
                            <br>
                          @endforeach
                        </td>
                        <td>{{ $item->nama_dosen }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade" id="dhuha" role="tabpanel" aria-labelledby="sd">
                  <table cellpadding="7" border="1" width="100%" height="25%" class="text-center" >
                    <thead bgcolor="#F0F1F1">
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama Mentee</th>
                        <th scope="col">Total Shalat Dhuha (x/pekan)</th>
                        <th scope="col">Nama Kelompok</th>
                        <th scope="col">Nama Mentor</th>
                        <th scope="col">Nama Dosen</th>                          
                      </tr>
                    </thead>
                    <tbody>
                      @php
                          $amalan = DB::table('amalan_yaumis')
                            ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                            ->leftJoin('mahasiswas', 'amalan_yaumis.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', 'kelompoks.id_kel')
                            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                            ->leftJoin('aktifitas', 'amalan_yaumis.id_aktifitas', '=', 'aktifitas.id_aktifitas')
                            ->select(
                                'amalan_yaumis.*',
                                'mahasiswas.*',
                                'detail_mentees.*',
                                'kelompoks.*',
                                'detail_kelas.*',
                                'kelas.*',
                                'dosens.*',
                                'aktifitas.*',
                                'pertemuans.*',
                                'periodes.*'
                            )
                            ->where('aktifitas.id_aktifitas', '6')
                            ->where('amalan_yaumis.id_pertemuan', Request::get('id_pertemuan'))
                            ->where('kelompoks.id_periode', Request::get('id_periode'))
                            ->orderBy('amalan_yaumis.isian', 'DESC')
                            ->limit(5)
                            ->get();
                      @endphp   
                      @foreach ($amalan as $no =>$item)                      
                      <tr>
                        <th scope="row">{{ $no+1 }}</th>
                        <td>{{ $item->nim }}</td>
                        <td>{{ $item->nama_mhs }}</td>                          
                        <td><b>{{ $item->isian }}</b></td>
                        <td>{{ $item->nama_kel }}</td>
                        <td>
                          @php
                            $detail_mentor = DB::table('detail_mentors')                            
                              ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                              ->select('detail_mentors.nim', 'mahasiswas.nama_mhs')
                              ->where('id_kel', $item->id_kel)
                              ->get();
                          @endphp
                          @foreach($detail_mentor as $key => $data)
                            Mentor {{ $key+1 }} : {{ $data->nama_mhs }}
                            <br>
                          @endforeach
                        </td>
                        <td>{{ $item->nama_dosen }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table> 
                </div>
                <div class="tab-pane fade" id="berjamaah" role="tabpanel" aria-labelledby="sbdm">
                  <table cellpadding="7" border="1" width="100%" height="25%" class="text-center" >
                    <thead bgcolor="#F0F1F1">
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama Mentee</th>
                        <th scope="col">Total Shalat Berjamaah di Masjid (x/pekan)</th>
                        <th scope="col">Nama Kelompok</th>
                        <th scope="col">Nama Mentor</th>
                        <th scope="col">Nama Dosen</th>                          
                      </tr>
                    </thead>
                    <tbody>
                      @php
                          $amalan = DB::table('amalan_yaumis')
                            ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                            ->leftJoin('mahasiswas', 'amalan_yaumis.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', 'kelompoks.id_kel')
                            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                            ->leftJoin('aktifitas', 'amalan_yaumis.id_aktifitas', '=', 'aktifitas.id_aktifitas')
                            ->select(
                                'amalan_yaumis.*',
                                'mahasiswas.*',
                                'detail_mentees.*',
                                'kelompoks.*',
                                'detail_kelas.*',
                                'kelas.*',
                                'dosens.*',
                                'aktifitas.*',
                                'pertemuans.*',
                                'periodes.*'
                            )
                            ->where('aktifitas.id_aktifitas', '7')
                            ->where('amalan_yaumis.id_pertemuan', Request::get('id_pertemuan'))
                            ->where('kelompoks.id_periode', Request::get('id_periode'))
                            ->orderBy('amalan_yaumis.isian', 'DESC')
                            ->limit(5)
                            ->get();
                      @endphp   
                      @foreach ($amalan as $no =>$item)                      
                      <tr>
                        <th scope="row">{{ $no+1 }}</th>
                        <td>{{ $item->nim }}</td>
                        <td>{{ $item->nama_mhs }}</td>                          
                        <td><b>{{ $item->isian }}</b></td>
                        <td>{{ $item->nama_kel }}</td>
                        <td>
                          @php
                            $detail_mentor = DB::table('detail_mentors')                            
                              ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                              ->select('detail_mentors.nim', 'mahasiswas.nama_mhs')
                              ->where('id_kel', $item->id_kel)
                              ->get();
                          @endphp
                          @foreach($detail_mentor as $key => $data)
                            Mentor {{ $key+1 }} : {{ $data->nama_mhs }}
                            <br>
                          @endforeach
                        </td>
                        <td>{{ $item->nama_dosen }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade" id="buku" role="tabpanel" aria-labelledby="mbi">
                  <table cellpadding="7" border="1" width="100%" height="25%" class="text-center" >
                    <thead bgcolor="#F0F1F1">
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama Mentee</th>
                        <th scope="col">Total Membaca Buku Islami (x/pekan)</th>
                        <th scope="col">Nama Kelompok</th>
                        <th scope="col">Nama Mentor</th>
                        <th scope="col">Nama Dosen</th>                          
                      </tr>
                    </thead>
                    <tbody>
                      @php
                          $amalan = DB::table('amalan_yaumis')
                            ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                            ->leftJoin('mahasiswas', 'amalan_yaumis.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', 'kelompoks.id_kel')
                            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                            ->leftJoin('aktifitas', 'amalan_yaumis.id_aktifitas', '=', 'aktifitas.id_aktifitas')
                            ->select(
                                'amalan_yaumis.*',
                                'mahasiswas.*',
                                'detail_mentees.*',
                                'kelompoks.*',
                                'detail_kelas.*',
                                'kelas.*',
                                'dosens.*',
                                'aktifitas.*',
                                'pertemuans.*',
                                'periodes.*'
                            )
                            ->where('aktifitas.id_aktifitas', '8')
                            ->where('amalan_yaumis.id_pertemuan', Request::get('id_pertemuan'))
                            ->where('kelompoks.id_periode', Request::get('id_periode'))
                            ->orderBy('amalan_yaumis.isian', 'DESC')
                            ->limit(5)
                            ->get();
                      @endphp   
                      @foreach ($amalan as $no =>$item)                      
                      <tr>
                        <th scope="row">{{ $no+1 }}</th>
                        <td>{{ $item->nim }}</td>
                        <td>{{ $item->nama_mhs }}</td>                          
                        <td><b>{{ $item->isian }}</b></td>
                        <td>{{ $item->nama_kel }}</td>
                        <td>
                          @php
                            $detail_mentor = DB::table('detail_mentors')                            
                              ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                              ->select('detail_mentors.nim', 'mahasiswas.nama_mhs')
                              ->where('id_kel', $item->id_kel)
                              ->get();
                          @endphp
                          @foreach($detail_mentor as $key => $data)
                            Mentor {{ $key+1 }} : {{ $data->nama_mhs }}
                            <br>
                          @endforeach
                        </td>
                        <td>{{ $item->nama_dosen }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade" id="riyadhoh" role="tabpanel" aria-labelledby="r">
                  <table cellpadding="7" border="1" width="100%" height="25%" class="text-center" >
                    <thead bgcolor="#F0F1F1">
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama Mentee</th>
                        <th scope="col">Total Riyadhoh (x/pekan)</th>
                        <th scope="col">Nama Kelompok</th>
                        <th scope="col">Nama Mentor</th>
                        <th scope="col">Nama Dosen</th>                          
                      </tr>
                    </thead>
                    <tbody>
                      @php
                          $amalan = DB::table('amalan_yaumis')
                            ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                            ->leftJoin('mahasiswas', 'amalan_yaumis.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', 'kelompoks.id_kel')
                            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                            ->leftJoin('aktifitas', 'amalan_yaumis.id_aktifitas', '=', 'aktifitas.id_aktifitas')
                            ->select(
                                'amalan_yaumis.*',
                                'mahasiswas.*',
                                'detail_mentees.*',
                                'kelompoks.*',
                                'detail_kelas.*',
                                'kelas.*',
                                'dosens.*',
                                'aktifitas.*',
                                'pertemuans.*',
                                'periodes.*'
                            )
                            ->where('aktifitas.id_aktifitas', '9')
                            ->where('amalan_yaumis.id_pertemuan', Request::get('id_pertemuan'))
                            ->where('kelompoks.id_periode', Request::get('id_periode'))
                            ->orderBy('amalan_yaumis.isian', 'DESC')
                            ->limit(5)
                            ->get();
                      @endphp   
                      @foreach ($amalan as $no =>$item)                      
                      <tr>
                        <th scope="row">{{ $no+1 }}</th>
                        <td>{{ $item->nim }}</td>
                        <td>{{ $item->nama_mhs }}</td>                          
                        <td><b>{{ $item->isian }}</b></td>
                        <td>{{ $item->nama_kel }}</td>
                        <td>
                          @php
                            $detail_mentor = DB::table('detail_mentors')                            
                              ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                              ->select('detail_mentors.nim', 'mahasiswas.nama_mhs')
                              ->where('id_kel', $item->id_kel)
                              ->get();
                          @endphp
                          @foreach($detail_mentor as $key => $data)
                            Mentor {{ $key+1 }} : {{ $data->nama_mhs }}
                            <br>
                          @endforeach
                        </td>
                        <td>{{ $item->nama_dosen }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade" id="agenda" role="tabpanel" aria-labelledby="au">
                  <table cellpadding="7" border="1" width="100%" height="25%" class="text-center" >
                    <thead bgcolor="#F0F1F1">
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama Mentee</th>
                        <th scope="col">Total Agenda Ukhuwah (x/bulan)</th>
                        <th scope="col">Nama Kelompok</th>
                        <th scope="col">Nama Mentor</th>
                        <th scope="col">Nama Dosen</th>                          
                      </tr>
                    </thead>
                    <tbody>
                      @php
                          $amalan = DB::table('amalan_yaumis')
                            ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                            ->leftJoin('mahasiswas', 'amalan_yaumis.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', 'kelompoks.id_kel')
                            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                            ->leftJoin('aktifitas', 'amalan_yaumis.id_aktifitas', '=', 'aktifitas.id_aktifitas')
                            ->select(
                                'amalan_yaumis.*',
                                'mahasiswas.*',
                                'detail_mentees.*',
                                'kelompoks.*',
                                'detail_kelas.*',
                                'kelas.*',
                                'dosens.*',
                                'aktifitas.*',
                                'pertemuans.*',
                                'periodes.*'
                            )
                            ->where('aktifitas.id_aktifitas', '11')
                            ->where('amalan_yaumis.id_pertemuan', Request::get('id_pertemuan'))
                            ->where('kelompoks.id_periode', Request::get('id_periode'))
                            ->orderBy('amalan_yaumis.isian', 'DESC')
                            ->limit(5)
                            ->get();
                      @endphp   
                      @foreach ($amalan as $no =>$item)                      
                      <tr>
                        <th scope="row">{{ $no+1 }}</th>
                        <td>{{ $item->nim }}</td>
                        <td>{{ $item->nama_mhs }}</td>                          
                        <td><b>{{ $item->isian }}</b></td>
                        <td>{{ $item->nama_kel }}</td>
                        <td>
                          @php
                            $detail_mentor = DB::table('detail_mentors')                            
                              ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                              ->select('detail_mentors.nim', 'mahasiswas.nama_mhs')
                              ->where('id_kel', $item->id_kel)
                              ->get();
                          @endphp
                          @foreach($detail_mentor as $key => $data)
                            Mentor {{ $key+1 }} : {{ $data->nama_mhs }}
                            <br>
                          @endforeach
                        </td>
                        <td>{{ $item->nama_dosen }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table> 
                </div>
                <div class="tab-pane fade" id="rawatib" role="tabpanel" aria-labelledby="sr">
                  <table cellpadding="7" border="1" width="100%" height="25%" class="text-center" >
                    <thead bgcolor="#F0F1F1">
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama Mentee</th>
                        <th scope="col">Total Shalat Rawatib (x/hari)</th>
                        <th scope="col">Nama Kelompok</th>
                        <th scope="col">Nama Mentor</th>
                        <th scope="col">Nama Dosen</th>                          
                      </tr>
                    </thead>
                    <tbody>
                      @php
                          $amalan = DB::table('amalan_yaumis')
                            ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                            ->leftJoin('mahasiswas', 'amalan_yaumis.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', 'kelompoks.id_kel')
                            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                            ->leftJoin('aktifitas', 'amalan_yaumis.id_aktifitas', '=', 'aktifitas.id_aktifitas')
                            ->select(
                                'amalan_yaumis.*',
                                'mahasiswas.*',
                                'detail_mentees.*',
                                'kelompoks.*',
                                'detail_kelas.*',
                                'kelas.*',
                                'dosens.*',
                                'aktifitas.*',
                                'pertemuans.*',
                                'periodes.*'
                            )
                            ->where('aktifitas.id_aktifitas', '12')
                            ->where('amalan_yaumis.id_pertemuan', Request::get('id_pertemuan'))
                            ->where('kelompoks.id_periode', Request::get('id_periode'))
                            ->orderBy('amalan_yaumis.isian', 'DESC')
                            ->limit(5)
                            ->get();
                      @endphp   
                      @foreach ($amalan as $no =>$item)                      
                      <tr>
                        <th scope="row">{{ $no+1 }}</th>
                        <td>{{ $item->nim }}</td>
                        <td>{{ $item->nama_mhs }}</td>                          
                        <td><b>{{ $item->isian }}</b></td>
                        <td>{{ $item->nama_kel }}</td>
                        <td>
                          @php
                            $detail_mentor = DB::table('detail_mentors')                            
                              ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                              ->select('detail_mentors.nim', 'mahasiswas.nama_mhs')
                              ->where('id_kel', $item->id_kel)
                              ->get();
                          @endphp
                          @foreach($detail_mentor as $key => $data)
                            Mentor {{ $key+1 }} : {{ $data->nama_mhs }}
                            <br>
                          @endforeach
                        </td>
                        <td>{{ $item->nama_dosen }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>                
              </div>
            </div>
          </div>
        </div>
        @php
          endif;
        @endphp 
      </div>
    </div>
  </div>
  @php
    endif;
  @endphp 
</div>
@endsection

