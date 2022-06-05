@extends('layouts.master')
@section('title', 'Laporan')
@section('section-header')
<div class="section-header">
    <h1>Laporan Mentoring</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Laporan Mentoring</div>
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
            $mentor = DB::table('detail_mentors')
                ->where('nim', session('nip_nim'))->first();
            $laporan = DB::table('laporans')
                ->leftJoin('pertemuans', 'laporans.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                ->leftJoin('mahasiswas', 'laporans.nim', '=', 'mahasiswas.nim')
                ->leftJoin('kelompoks', 'laporans.id_kel', '=', 'kelompoks.id_kel')
                ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode') 
                ->select(
                    'laporans.*', 
                    'pertemuans.*',
                    'mahasiswas.*', 
                    'kelompoks.*', 
                    'periodes.*')
                ->where('kelompoks.id_periode', Request::get('id_periode'))
                ->where('mahasiswas.nim', $mentor->nim)
                ->orderBy('laporans.tgl', 'DESC')
                ->get();            

        } elseif (session('id_role') == 4) {
            //admin
            $laporan = DB::table('laporans')
                ->leftJoin('pertemuans', 'laporans.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                ->leftJoin('mahasiswas', 'laporans.nim', '=', 'mahasiswas.nim')
                ->leftJoin('kelompoks', 'laporans.id_kel', '=', 'kelompoks.id_kel')
                ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode') 
                ->select(
                    'laporans.*', 
                    'pertemuans.*',
                    'mahasiswas.*', 
                    'kelompoks.*', 
                    'periodes.*')
                ->where('kelompoks.id_periode', Request::get('id_periode'))
                ->orderBy('laporans.tgl', 'DESC')
                ->get();
        }
        @endphp
        @if(session('id_role') == 1)
        <div class="buttons">
          <a href="{{ route('create.laporan') }}" class="btn btn-lg btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Tambah Laporan</a>
        </div>
         @endif
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="table-1">
                    <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Periode</th>
                        <th scope="col">Mentor</th>
                        <th scope="col">Nama Kelompok</th>
                        <th scope="col">Pertemuan</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($laporan as $no => $item)
                        <tr>
                          <th scope="row">{{ $no+1 }}</th>
                          <td>{{ $item->periode }}</td>
                          <td>{{ $item->nama_mhs }}</td>
                          <td>{{ $item->nama_kel }}</td>  
                          <td>{{ $item->pertemuan }}</td> 
                          <td>{{ $item->tgl }}</td>
                          <td><a target="_blank" href="{{  asset('gambar/'.$item->gambar)  }}">{{ $item->gambar }}</a></td>
                          <td>
                            @if(session('id_role') == 1)
                              <a href="{{ route('edit.laporan', $item->id_laporan) }}" class="btn btn-info">Edit</a>
                            @endif
                            <a onclick="return confirm('Yakin ingin hapus data ini?')" href="{{ route('delete.laporan', $item->id_laporan) }}" class="btn btn-danger">Delete</a>
                            <a href="{{ route('show.laporan', $item->id_laporan) }}" class="btn btn-dark">Detail</a>
                          </td>
                        </tr>
                      @endforeach
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

