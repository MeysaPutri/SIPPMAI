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
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                  <form action="{{route('cetak.nilai.store')}}" method="post">
                      @csrf
                <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Periode</label>
                            <select name="id_periode" id="id_periode" class="form-control select2" disabled required="" style="width: 100%">
                                  <option value="">Pilih Periode</option>
                                  @foreach ($periode as $item)
                                  <option value="{{$item->id_periode}}">{{$item->periode}}</option>
                                  @endforeach
                            </select> 
                            <script>
                              document.getElementById('id_periode').value = "{{Request::get('id_periode')}}"
                            </script>                 
                        </div>
                      </div>
                      @php
                        if(isset($_GET['id_periode'])) :
                      @endphp
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Berdasarkan</label>
                            <select name="key" id="key" class="form-control select2" required="" style="width: 100%">
                                  <option value="">Pilih</option>
                                  <option value="kelas">Kelas</option>
                                  <option value="fakultas">Fakultas</option>
                                  <option value="kelompok">Kelompok</option>
                            </select>                  
                        </div>
                      </div>
                      <div class="col-md-4" id="filter1" hidden>
                        <div class="form-group">
                          <label>Filter</label>
                          @php
                              $kelas = DB::table('kelas')
                                ->leftJoin('periodes', 'kelas.id_periode', 'periodes.id_periode')
                                ->where('kelas.id_periode', Request::get('id_periode'))
                                ->get();
                          @endphp
                            <select name="id_kelas" id="id_kelas" class="form-control select2" required="" style="width: 100%" disabled>
                              <option value="">Pilih Filter</option>    
                              <option value="semua">Tampilkan Semua</option>
                                @foreach ($kelas as $item)
                                <option value="{{$item->id_kelas}}">{{$item->nama_kelas}} - {{$item->sks}}</option>
                                @endforeach
                            </select>                  
                        </div>
                      </div>
                      <div class="col-md-4" id="filter2" hidden>
                        <div class="form-group">
                          <label>Filter</label>
                          @php
                              $fakultas = DB::table('fakultas')
                                ->leftJoin('jurusans', 'fakultas.id_fakultas', '=', 'jurusans.id_fakultas')
                                ->leftJoin('mahasiswas', 'jurusans.id_jurusan', '=', 'mahasiswas.id_jurusan')
                                ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                                ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                                ->leftJoin('periodes', 'kelas.id_periode', 'periodes.id_periode')
                                ->where('kelas.id_periode', Request::get('id_periode'))
                                ->get();
                          @endphp
                            <select name="id_fakultas" id="id_fakultas" class="form-control select2" required="" style="width: 100%" disabled>
                              <option value="">Pilih Filter</option>        
                              <option value="semua">Tampilkan Semua</option>
                                  @foreach ($fakultas as $item)
                                  <option value="{{$item->id_fakultas}}">{{$item->nama_fakultas}}</option>
                                  @endforeach
                            </select>                  
                        </div>
                      </div>
                      <div class="col-md-4" id="filter3" hidden>
                        <div class="form-group">
                          <label>Filter</label>
                          @php
                              $kelompok = DB::table('kelompoks')
                                ->leftJoin('periodes', 'kelompoks.id_periode', 'periodes.id_periode')
                                ->where('kelompoks.id_periode', Request::get('id_periode'))
                                ->get();
                          @endphp
                            <select name="id_kel" id="id_kel" class="form-control select2" required="" style="width: 100%" disabled>
                              <option value="">Pilih Filter</option>    
                              <option value="semua">Tampilkan Semua</option>
                                  @foreach ($kelompok as $item)
                                  <option value="{{$item->id_kel}}">{{$item->nama_kel}}</option>
                                  @endforeach
                            </select>                  
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>&nbsp;</label>
                         <button type="submit" class="btn btn-primary btn-block">Cetak Nilai Mentoring</button>     
                        </div>
                      </div>
                      @php
                          endif;
                      @endphp  
                </div>
                </form>
              </div>
            </div>     
        </div>
    </div>
</div>

@push('after-scripts')
<script>
      $(function () {
          $('#id_periode').on('change', function () {
              axios.post('{{ route('dropdown.nilai') }}', {id_periode: $(this).val()})
                  .then(function (response) {
                      $('#id_kelas').empty();
                      $('#id_fakultas').empty();
                      $('#id_kel').empty();

                  $.each(response.data, function (id_periode, periode) {
                      $('#id_kelas').append(new Option(nama_kelas, id_kelas))
                      $('#id_fakultas').append(new Option(nama_fakultas, id_fakultas))
                      $('#id_kel').append(new Option(nama_kel, id_kel))
                  })
              });
          });
      });
    </script>
    <script>
        $('#key').change(function(e){
            $('#filter1').attr('hidden','')
            $('#filter2').attr('hidden','')
            $('#filter3').attr('hidden','')
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
            }
        })
    </script>
@endpush

public function cetak(Request $r) //method untuk mengambil nilai cetak(store) dan mencetaknya
    {
        // dd($r->all());
        $key = $r->key;
        if ($key == 'kelas') {
            if ($r->id_kelas == 'semua') {
                //cetak semua kelas
                $kelas = DB::table('kelas')
                    ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                    ->where('kelas.id_periode', $r->id_periode)
                    ->get();
                foreach ($kelas as $k => $kk) {
                    $a[] = [
                        'nama_kelas' => $kk->nama_kelas,
                        'nama_dosen' => DB::table('kelas')
                            ->join('dosens', 'kelas.nip', '=', 'dosens.nip')
                            ->where('kelas.id_kelas', $kk->id_kelas)
                            ->first()->nama_dosen,
                        'jml_mhs' => DB::table('nilai_mentorings')
                            ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->where('detail_kelas.id_kelas', $kk->id_kelas)->count(),
                        'data_mhs' => DB::table('nilai_mentorings')
                            ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                            ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                            ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                            ->where('kelas.id_kelas', $kk->id_kelas)
                            ->where('kelas.id_periode', $r->id_periode)
                            ->get(),
                    ];
                }
                $data['nilai'] = $a;
                $data['periode'] = DB::table('periodes')->where('id_periode', $r->id_periode)->first()->periode;
                return view('pages.nilai.cetak_all_kelas', $data);
            } else {
                $nilai = DB::table('nilai_mentorings')
                    ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                    ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                    ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                    ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                    ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                    ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                    ->where('kelas.id_kelas', $r->id_kelas)
                    ->where('kelas.id_periode', $r->id_periode)
                    ->get();
                return view('pages.nilai.cetak', [
                    'nilai' => $nilai,
                    'periode' => DB::table('periodes')->where('id_periode', $r->id_periode)->first(),
                    'ket1' => 'Nama Kelas',
                    'val1' => DB::table('kelas')
                        ->where('id_kelas', $r->id_kelas)->first()->nama_kelas,

                    'ket2' => 'Dosen',
                    'val2' => DB::table('kelas')
                        ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                        ->where('kelas.id_kelas', $r->id_kelas)
                        ->first()->nama_dosen,
                    'ket3' => 'Jumlah Mahasiswa',
                    'val3' => DB::table('nilai_mentorings')
                        ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                        ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                        ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                        ->where('detail_kelas.id_kelas', $r->id_kelas)->count(),
                ]);
            }
        } elseif ($key == 'fakultas') {
            if ($r->id_fakultas == 'semua') {
                $fakultas = DB::table('fakultas')
                    ->leftJoin('jurusans', 'fakultas.id_fakultas', '=', 'jurusans.id_fakultas')
                    ->leftJoin('mahasiswas', 'jurusans.id_jurusan', '=', 'mahasiswas.id_jurusan')
                    ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                    ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                    ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                    ->where('kelas.id_periode', $r->id_periode)
                    ->get();
                foreach ($fakultas as $f => $ff) {
                    $a[] = [
                        'nama_fakultas' => $ff->nama_fakultas,
                        'jml_mhs' => DB::table('nilai_mentorings')
                            ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')                            
                            ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                            ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                            ->where('fakultas.id_fakultas', $ff->id_fakultas)->count(),
                        'data_mhs' => DB::table('nilai_mentorings')
                            ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                            ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                            ->where('fakultas.id_fakultas', $ff->id_fakultas)
                            ->get(),
                    ];
                }
                $data['nilai'] = $a;
                $data['periode'] = DB::table('periodes')->where('id_periode', $r->id_periode)->first()->periode;
                return view('pages.nilai.cetak_all_fakultas', $data);
            } else {
                $nilai = DB::table('nilai_mentorings')
                    ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                    ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                    ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                    ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                    ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                    ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                    ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                    ->where('fakultas.id_fakultas', $r->id_fakultas)
                    ->where('kelompoks.id_periode', $r->id_periode)
                    ->get();
                return view('pages.nilai.cetak', [
                    'nilai' => $nilai,
                    'periode' => DB::table('periodes')->where('id_periode', $r->id_periode)->first(),
                    'ket1' => 'Nama Fakultas',
                    'val1' => DB::table('fakultas')->where('fakultas.id_fakultas', $r->id_fakultas)->first()->nama_fakultas,
                    'ket2' => 'Jumlah Mahasiswa',
                    'val2' => DB::table('nilai_mentorings')
                        ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                        ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                        ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                        ->where('jurusans.id_fakultas', $r->id_fakultas)->count(),
                ]);
            }
        } elseif ($key == 'kelompok') {
            if ($r->id_kel == 'semua') {
                $kelompok = DB::table('kelompoks')
                    ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                    ->where('kelompoks.id_periode', $r->id_periode)
                    ->get();
                foreach ($kelompok as $k => $kk) {
                    $a[] = [
                        'nama_kelompok' => DB::table('kelompoks')->where('id_kel', $kk->id_kel)->first()->nama_kel,
                        'mentor' => DB::table('detail_mentors')
                            ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('kelompoks', 'detail_mentors.id_kel', '=', 'kelompoks.id_kel')
                            ->where('detail_mentors.id_kel', $kk->id_kel)
                            ->get(),
                        'jml_mhs' => DB::table('nilai_mentorings')
                            ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                            ->where('detail_mentees.id_kel', $kk->id_kel)->count(),
                        'data_mhs' => DB::table('nilai_mentorings')
                            ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                            ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                            ->where('detail_mentees.id_kel', $kk->id_kel)
                            ->where('kelompoks.id_periode', $r->id_periode)
                            ->get(),
                    ];
                }
                $data['nilai'] = $a;
                $data['periode'] = DB::table('periodes')->where('id_periode', $r->id_periode)->first()->periode;
                return view('pages.nilai.cetak_all_kelompok', $data);
            } else {
                $nilai = DB::table('nilai_mentorings')
                    ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                    ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                    ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                    ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                    ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                    ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                    ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                    ->where('kelompoks.id_kel', $r->id_kel)
                    ->where('kelompoks.id_periode', $r->id_periode)
                    ->get();
                return view('pages.nilai.cetak', [
                    'nilai' => $nilai,
                    'periode' => DB::table('periodes')->where('id_periode', $r->id_periode)->first(),
                    'ket1' => 'Nama Kelompok',
                    'val1' => DB::table('kelompoks')->where('id_kel', $r->id_kel)->first()->nama_kel,
                    'mentor' => DB::table('detail_mentors')
                        ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                        ->leftJoin('kelompoks', 'detail_mentors.id_kel', '=', 'kelompoks.id_kel')
                        ->where('detail_mentors.id_kel', $r->id_kel)
                        ->get(),
                    'ket2' => 'Jumlah Mahasiswa',
                    'val2' => DB::table('nilai_mentorings')
                        ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                        ->leftJoin('detail_mentors', 'mahasiswas.nim', '=', 'detail_mentors.nim')
                        ->leftJoin('kelompoks', 'detail_mentors.id_kel', '=', 'kelompoks.id_kel')
                        ->where('kelompoks.id_kel', $r->id_kel)->count(),

                ]);
            }
        }
    }
@endsection


