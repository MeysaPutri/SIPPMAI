@extends('layouts.master')
@section('title', 'Data Kelas')
@section('section-header')
<div class="section-header">
    <h1>Data Kelas</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Kelas</div>
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

            if (session('id_role') == 2) {
              $dosen = DB::table('dosens')
                  ->where('dosens.nip', session('nip_nim'))->first();
              $kelas = DB::table('kelas')
                  ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                  ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                  ->select('kelas.*', 'dosens.*', 'periodes.id_periode', 'periodes.periode')
                  ->where('kelas.id_periode', Request::get('id_periode'))
                  ->where('dosens.nip', $dosen->nip)
                  ->get();
            } else{        
                $kelas = DB::table('kelas')
                    ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                    ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                    ->select('kelas.*', 'dosens.*', 'periodes.id_periode', 'periodes.periode')
                    ->where('kelas.id_periode', Request::get('id_periode'))
                    ->get();
            }
        @endphp          
        @if(session('id_role') == 4)
          <div class="buttons">
            <a href="{{ route('create.kelas') }}" class="btn btn-lg btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Tambah Kelas</a>
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
                        <th scope="col">Nama Kelas</th>
                        <th scope="col">Jumlah SKS</th>
                        <th scope="col">Nama Dosen</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($kelas as $no =>$item)        
                      <tr>
                        <th scope="row">{{ $no+1}}</th>
                        <td>{{ $item->periode }}</td>
                        <td>{{ $item->nama_kelas }}</td>
                        <td>{{ $item->sks }}</td>
                        <td>{{ $item->nama_dosen }}</td>
                        <td>
                          @if(session('id_role') == 4)
                            <a href="{{ route('edit.kelas', $item->id_kelas) }}" class="btn btn-info">Edit</a>
                            <a onclick="return confirm('Yakin ingin hapus data ini?')" href="{{ route('delete.kelas', $item->id_kelas) }}" class="btn btn-danger">Delete</a>
                          @endif
                          <a href="{{ route('detail_kelas', $item->id_kelas) }}" class="btn btn-dark">Detail Mahasiswa</a>
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
<script>
  document.getElementById('id_periode').value = "{{Request::get('id_periode')}}"
</script>
@endsection

