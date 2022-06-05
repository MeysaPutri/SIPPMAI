@extends('layouts.master')
@section('title', 'Nilai')
@section('section-header')
<div class="section-header">
    <h1>Nilai Mentoring</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item a">Nilai Mentoring</div>
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
              //mentor
              $detail_mentor = DB::table('detail_mentors')
                  ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                  ->where('mahasiswas.nim', session('nip_nim'))->first();
              $nilai = DB::table('nilai_mentorings')
                  ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                  ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                  ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                  ->leftJoin('detail_mentors', 'kelompoks.id_kel', '=', 'detail_mentors.id_kel')
                  ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                  ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                  ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                  ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                  ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                  ->where('detail_mentors.nim', $detail_mentor->nim)
                  ->where('kelompoks.id_periode', Request::get('id_periode'))
                  ->get();
            } elseif (session('id_role') == 2) {
                //dosen
                $id_dosen = DB::table('dosens')->where('nip', session('nip_nim'))->first();
                $nilai = DB::table('nilai_mentorings')
                    ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')                
                    ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                    ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                    ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                    ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                    ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                    ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                    ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                    ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                    ->where('dosens.nip', $id_dosen->nip)
                    ->where('kelompoks.id_periode', Request::get('id_periode'))
                    ->get();
            } elseif (session('id_role') == 4) {
                //admin
                $nilai = DB::table('nilai_mentorings')
                    ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')                
                    ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                    ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                    ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                    ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                    ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                    ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                    ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                    ->where('kelompoks.id_periode', Request::get('id_periode'))
                    ->get();
            }

        @endphp 
          <div class="buttons">
            @if (session('id_role') == 1)             
            <a href="{{ route('create.nilai') }}" class="btn btn-lg btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Tambah Nilai Mentoring</a>
            @endif
            @if (session('id_role') == 4)
              <a  href="{{route('cetak.nilai')}}" class="btn btn-lg btn-icon icon-left btn-primary"><i class="fa fa-print"></i> Cetak Nilai Mentoring</a>
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
                        <th scope="col">Mentee</th>
                        <th scope="col">Fakultas</th>
                        <th scope="col">Kelas</th>
                        <th scope="col">Kelompok</th>
                        <th scope="col">Penilai</th>
                        <th scope="col">Total Nilai</th>
                      @if (session('id_role') == 1)
                        <th scope="col">Aksi</th>
                        @endif
                        @if (session('id_role') == 4 || session('id_role') == 2)
                        <th scope="col">Aksi</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>     
                      @foreach ($nilai as $item)
                      <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$item->periode}}</td>
                        <td>{{$item->nim}}</td>
                        <td>{{$item->nama_mhs}}</td>
                        <td>{{$item->nama_fakultas}}</td>
                        <td>{{$item->nama_kelas}} - {{ $item->sks }}</td>
                        <td>{{$item->nama_kel}}</td>
                        <td>{{$item->penilai}}</td>
                        <td>{{$item->total_nilai}}</td>
                        @if (session('id_role') == 1)
                        <td>
                          <a id="edit" href="{{ route('edit.nilai', $item->id_nm) }}" class="btn btn-info">Edit</a>
                          <a onclick="return confirm('Yakin ingin hapus data ini?')" href="{{route('delete.nilai', $item->id_nm)}}" class="btn btn-danger">Delete</a>
                          <a href="{{route('show.nilai', $item->id_nm)}}" class="btn btn-dark">Detail</a>
                        </td>
                        @endif
                        @if (session('id_role') == 4 || session('id_role') == 2)
                      <td>
                        <a href="{{route('show.nilai', $item->id_nm)}}" class="btn btn-dark">Detail</a>
                      </td>
                        @endif
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Filter Cetak Nilai Mentoring</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="form-group">
         <label for="">Fakultas</label>
         @php
             $fakultas = DB::table('fakultas')->get();
         @endphp
         <select name="id_fakultas" id="id_fakultas" class="form-control" required>
           <option value="">Pilih Fakultas</option>
           @foreach ($fakultas as $item)
           <option value="{{$item->id_fakultas}}">{{$item->nama_fakultas}}</option>
           @endforeach
         </select>
       </div>
       <div class="form-group">
        <label for="">Kelas</label>
        @php
            $kelas = DB::table('kelas')->get();
        @endphp
        <select name="id_kelas" id="id_kelas" class="form-control" required>
          <option value="">Pilih Kelas</option>
          @foreach ($kelas as $i)
          <option value="{{$i->id_kelas}}">{{$i->nama_kelas}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="">Kelompok</label>
        @php
            $kel = DB::table('kelompoks')->get();
        @endphp
        <select name="id_kel" id="id_kel" class="form-control">
          <option value="">Pilih Kelompok</option>
          @foreach ($kel as $k)
          <option value="{{$k->id_kel}}">{{$k->nama_kel}}</option>
          @endforeach
        </select>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button onclick="btn_cetak()" type="button" class="btn btn-primary">Cetak</button>
      </div>
    </div>
  </div>
</div>

@push('page-scripts')
    <script>
     function cetak(){
       $('#exampleModal').modal();
       setTimeout(() => {
        $('.modal-backdrop').remove();
       }, 500);
       
     }

     function btn_cetak() {
        var id_fakultas = $('#id_fakultas option:selected').val();
        var id_kelas = $('#id_kelas option:selected').val();
        var id_kel = $('#id_kel option:selected').val();
        if (id_fakultas == "" || id_kelas == "" || id_kel == "") {
            alert('Inputan tidak boleh Kosong')
        } else {
            var baseUrl = './nilai/cetak';
            var url = baseUrl + '/' + id_fakultas + '/' + id_kelas + '/' + id_kel;
            // location.href = url;
            window.open(url, '_blank');
        }
    }
    </script>
@endpush
@endsection

