@extends('layouts.master')
@section('title', 'Detail Nilai')
@section('section-header')
<div class="section-header">
    <h1>Detail Nilai Mentoring</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('nilai') }}">Nilai Mentoring</a></div>
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
              <th>NIM</th>
              <td>:</td>
              <td>{{ $nilai->nim}}</td>
            </tr>
            <tr>
              <th>Mentee</th>
              <td>:</td>
              <td>{{ $nilai->nama_mhs}}</td>
            </tr>
            <tr>
              <th>Periode</th>
              <td>:</td>
              <td>{{ $nilai->periode}}</td>
            </tr>
            <tr>
              <th>Fakultas</th>
              <td>:</td>
              <td>{{ $nilai->nama_fakultas }}</td>
            </tr>
            <tr>
              <th>Kelas</th>
              <td>:</td>
              <td>{{ $nilai->nama_kelas }} - {{ $nilai->sks }}</td>
            </tr>
            <tr>
              <th>Kelompok</th>
              <td>:</td>
              <td>{{ $nilai->nama_kel }}</td>
            </tr>  
            <tr>
              <th>Penilai</th>
              <td>:</td>
              <td>{{ $nilai->penilai}}</td>
            </tr>          
          </table>
          <br>
          <table  cellpadding="7" border="1" width="65%" height="25%">
            <thead bgcolor="#F0F1F1">
              <tr class="text-center">
                <th>No</th>
                <th>Poin Penilaian</th>
                <th>Nilai</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center" rowspan="5"><b>1</b></td>
                <td colspan="3"><b>Kehadiran (20%)</b></td>
              </tr>
              <tr>
                <td>Hadir</td>
                <td class="text-center" >{{ $nilai->hadir}}</td>                
                <td class="text-center" rowspan="4">{{ $nilai->total_kehadiran }}</td>
              </tr>
              <tr>
                <td>Izin</td>                
                <td class="text-center">{{ $nilai->izin}}</td>
              </tr>
              <tr>
                <td>Alfa</td>                
                <td class="text-center">{{ $nilai->alfa}}</td>
              </tr>
              <tr>
                <td>Ujian Praktek</td>                
                <td class="text-center">{{ $nilai->pertemuan_ujian }}</td>
              </tr>
              <tr>
                <td class="text-center" rowspan="2"><b>2</b></td>
                <td colspan="3"><b>Nilai Pendalaman Materi (20%)</b></td>
              </tr>
              <tr>
                <td>Pendalaman Materi</td>
                <td class="text-center" >{{ $nilai->npendalaman_materi}}</td>                
                <td class="text-center">{{ $nilai->total_pendalaman }}</td>
              </tr> 
              <tr>
                <td class="text-center" rowspan="3"><b>3</b></td>
                <td colspan="3"><b>Nilai Ujian Praktek BBQ (25%)</b></td>
              </tr>
              <tr>
                <td>Baca Al-Quran</td>
                <td class="text-center" >{{ $nilai->baca_alquran}}</td>                
                <td class="text-center" rowspan="2">{{ $nilai->total_bbq  }}</td>
              </tr>
              <tr>
                <td>Hafalan</td>                
                <td class="text-center">{{ $nilai->hafalan}}</td>
              </tr>
              <tr>
                <td class="text-center" rowspan="3"><b>4</b></td>
                <td colspan="3"><b>Nilai Ujian Praktek Ibadah (25%)</b></td>
              </tr>
              <tr>
                <td>Wudu</td>
                <td class="text-center" >{{ $nilai->wudu}}</td>                
                <td class="text-center" rowspan="2">{{ $nilai->total_ibadah }}</td>
              </tr>
              <tr>
                <td>Shalat</td>                
                <td class="text-center">{{ $nilai->shalat}}</td>
              </tr>
              <tr>
                <td class="text-center" rowspan="2"><b>5</b></td>
                <td colspan="3"><b>Nilai Akhlak (10%)</b></td>
              </tr>
              <tr>
                <td>Akhlak</td>
                <td class="text-center" >{{ $nilai->akhlak}}</td>                
                <td class="text-center" >{{ $nilai->total_akhlak }}</td>
              </tr> 
              <tr class="text-center" bgcolor="#F0F1F1">
                <td colspan="3"><b>Total Nilai </b></td>
                <td>{{ $nilai->total_nilai }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

