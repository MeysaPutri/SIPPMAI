@extends('layouts.master')
@section('title', 'Persetujuan SCM')
@section('section-header')
<div class="section-header">
    <h1>Persetujuan SCM</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Persetujuan SCM</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
  <div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">           
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="table-1">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">NIM</th>
                    <th scope="col">Nama Mahasiswa</th>
                    <th scope="col">Status</th>
                    <th scope="col">Sedia</th>
                    <th scope="col">Alasan Tidak Bersedia</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>                  
                  @foreach($scm as $no =>$item)
                  <tr>
                    <th scope="row">{{ $no+1 }}</th>
                    <td>{{ $item->nim }}</td>
                    <td>{{ $item->nama_mhs }}</td>
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
                      @if($item->sedia ==1)
                        Ya, Bersedia
                      @elseif($item->sedia ==0)
                        Tidak Bersedia
                      @endif
                    </td>
                    <td>
                      @if($item->alasan ==null)
                        Tidak ada
                      @else
                        {{ $item->alasan}}
                      @endif
                    </td>  
                    <td>
                      <a href="{{ route('edit.scm', $item->nim) }}" class="btn btn-info">Edit</a> 
                    </td>                 
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>  
    </div>
  </div>
</div>

@endsection
