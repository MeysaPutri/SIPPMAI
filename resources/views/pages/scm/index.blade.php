@extends('layouts.master')
@section('title', 'SCM')
@section('section-header')
<div class="section-header">
    <h1>Suplemen Calon Mentor</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">SCM</div>
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
                  <script>
                    document.getElementById('id_periode').value = "{{Request::get('id_periode')}}"
                  </script>
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
            
            if (session('id_role') == 1) {
              $mentor = DB::table('detail_mentors')
                  ->where('nim', session('nip_nim'))->first();
              $scm = DB::table('scms')
                ->leftJoin('mahasiswas', 'scms.nim', '=', 'mahasiswas.nim')
                ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                ->leftJoin('detail_mentors', 'kelompoks.id_kel', '=', 'detail_mentors.id_kel')
                ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                ->leftJoin('statuses', 'scms.id_status', '=', 'statuses.id_status')
                ->where('kelompoks.id_periode', Request::get('id_periode'))
                ->where('detail_mentors.nim', $mentor->nim)
                ->get();
            }else{
              $scm = DB::table('scms')
                ->leftJoin('mahasiswas', 'scms.nim', '=', 'mahasiswas.nim')
                ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                ->leftJoin('statuses', 'scms.id_status', '=', 'statuses.id_status')
                ->where('kelompoks.id_periode', Request::get('id_periode'))
                ->get();
            }          
        @endphp  
      <div class="buttons">
        @if (session('id_role') == 4)
        <a  href="{{ route('cetak.scm') }}" class="btn btn-lg btn-icon icon-left btn-primary"><i class="fa fa-print"></i> Cetak Suplemen Calon Mentor</a>
        @endif
      </div>
        <div class="card">           
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="table-1">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Periode</th>
                    <th scope="col">NIM</th>
                    <th scope="col">Nama Mentee</th>
                    <th scope="col">Nama Kelompok</th>
                    <th scope="col">Nama Mentor</th>
                    <th scope="col">Nama Dosen</th>
                    <th scope="col">Sedia</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  
                  @foreach($scm as $no =>$item)
                  <tr>
                    <th scope="row">{{ $no+1 }}</th>
                    <td>{{ $item->periode }}</td>
                    <td>{{ $item->nim }}</td>
                    <td>{{ $item->nama_mhs }}</td>
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
                    @endforeach</td>
                    <td>{{ $item->nama_dosen }}</td>
                    <td>
                      @if($item->sedia == 1)
                        Ya, Bersedia
                      @else
                        Tidak Bersedia
                      @endif
                    </td>
                    <td>
                      @if($item->id_status == 2)
                        <a href="{{ route('status.scm', [$item->nim]) }}" 
                          @if(session('id_role')==4)
                            class="btn btn-danger"
                          @else
                          class="btn btn-danger disabled"
                          @endif>
                          <i class="fas fa-times"></i>&nbsp;&nbsp;Disapprove
                        </a>
                      @elseif($item->id_status == 1)
                        <a href="{{ route('status.scm', [$item->nim]) }}"
                          @if(session('id_role')==4)
                            class="btn btn-success"
                          @else
                            class="btn btn-success disabled"
                          @endif>
                          <i class="fas fa-check"></i>&nbsp;&nbsp;Approve
                        </a>
                      @elseif($item->id_status == 3)
                        <a href="{{ route('status.scm', [$item->nim]) }}"
                          @if(session('id_role')==4)
                            class="btn btn-warning"
                          @else
                            class="btn btn-warning disabled"
                          @endif>
                          <i class="far fa-file"></i>&nbsp;&nbsp;In Review
                        </a>
                      @endif
                    </td>
                    <td>
                      <a href="{{ route('show.scm', $item->nim) }}" class="btn btn-dark">Detail</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>  
      @php
        endif;
      @endphp   
    </div>
  </div>
</div>
@endsection
