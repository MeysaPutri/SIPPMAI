@extends('layouts.master')
@section('title', 'Detail SCM')
@section('section-header')
<div class="section-header">
    <h1>Detail Suplemen Calon Mentor</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('scm') }}">Suplemen Calon Mentor</a></div>
      <div class="breadcrumb-item">Detail</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <table cellpadding = "15">
            <tr>
              <th>Periode</th>
              <td>:</td>
              <td>{{ $items->periode }}</td>
            </tr>
            <tr>
              <th>NIM</th>
              <td>:</td>
              <td>{{ $items->nim }}</td>
            </tr>  
            <tr>
              <th>Nama Mentee</th>
              <td>:</td>
              <td>{{ $items->nama_mhs }}</td>
            </tr> 
            <tr>
              <th>Fakultas</th>
              <td>:</td>
              <td>{{ $items->nama_fakultas }}</td>
            </tr>  
            <tr>
              <th>Nama Kelompok</th>
              <td>:</td>
              <td>{{ $items->nama_kel }}</td>
            </tr>       
              @php
              $detail_mentor = DB::table('detail_mentors')                            
                ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                ->select('detail_mentors.nim', 'mahasiswas.nama_mhs')
                ->where('id_kel', $items->id_kel)
                ->get();
              @endphp
              @foreach($detail_mentor as $key => $data) 
              <tr>           
                <th>Mentor {{ $key+1 }}</th>
                <td>:</td>
                <td>{{ $data->nama_mhs }}</td>              
              </tr>
              @endforeach   
              <tr>
                <th>Nama Kelas</th>
                <td>:</td>
                <td>{{ $items->nama_kelas }} - {{ $items->sks }}</td>
              </tr>         
            <tr>
              <th>Nama Dosen</th>
              <td>:</td>
              <td>{{ $items->nama_dosen }}</td>
            </tr>
            <tr>
              <th>Status</th>
              <td>:</td>
              <td>              
                @foreach($status as $s)
                  {{ $s->status }}</td>
                @endforeach
            </tr>
            <tr>
              <th>Sedia</th>
              <td>:</td>
              <td>
                @if($items->sedia == 1)
                  Ya, Bersedia
                @else
                  Tidak Bersedia
                @endif
              </td>
            </tr>   
            <tr>
              <th>Alasan tidak bersedia</th>
              <td>:</td>
              <td>
                @if($items->sedia == 1)
                  Tidak ada
                @else
                  {{ $items->alasan }}
                @endif
              </td>
            </tr>            
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

