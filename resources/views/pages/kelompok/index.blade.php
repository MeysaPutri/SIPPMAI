@extends('layouts.master')
@section('title', 'Data Kelompok')
@section('section-header')
<div class="section-header">
    <h1>Data Kelompok</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Kelompok</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
  <div class="row">
    <div class="col-12 col-md-12 col-lg-">
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
              $kelompok = DB::table('kelompoks') 
                  ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                  ->leftJoin('detail_mentors', 'kelompoks.id_kel', '=', 'detail_mentors.id_kel')                
                  ->select('kelompoks.*', 'periodes.*', 'detail_mentors.*')                  
                  ->where('kelompoks.id_periode', Request::get('id_periode'))
                  ->where('detail_mentors.nim', $mentor->nim)
                  ->get();
              } else { 
                  $kelompok = DB::table('kelompoks') 
                  ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                  ->select('kelompoks.*', 'periodes.*')                  
                  ->where('kelompoks.id_periode', Request::get('id_periode'))
                  ->get();
              }           
        @endphp 
          @if(session('id_role') == 4)
            <div class="buttons">
              <a href="{{ route('create.kelompok') }}" class="btn btn-lg btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Tambah Kelompok</a>
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
                        <th scope="col">Nama Kelompok</th>                        
                        <th scope="col">Mentor</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($kelompok as $no =>$item)    
                        
                      <tr>
                        <th scope="row">{{ $no+1 }}</th>                        
                        <td>{{ $item->periode }}</td>
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
                        <td>
                          @if(session('id_role') == 4)
                            <a href="{{ route('edit.kelompok', $item->id_kel) }}" class="btn btn-info">Edit</a>
                            <a onclick="return confirm('Yakin ingin hapus data ini?')" href="{{ route('delete.kelompok', $item->id_kel)}}"
                              class="btn btn-danger">Delete</a>
                          @endif
                          <a href="{{ route('detail_mentee', $item->id_kel) }}" class="btn btn-dark">Detail Mentee</a>
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

