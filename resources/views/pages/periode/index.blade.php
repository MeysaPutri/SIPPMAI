@extends('layouts.master')
@section('title', 'Periode')
@section('section-header')
<div class="section-header">
    <h1>Periode</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Periode</div>
    </div>
</div>    
@endsection
@section('content')
<div class="buttons">
  @if(session('id_role') == 4)
  <a href="{{ route('create.periode') }}" class="btn btn-lg btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Tambah Periode</a>
  @endif
</div>
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
                        <th scope="col">Periode</th>
                        <th scope="col">Materi</th>
                        @if(session('id_role') == 4)
                        <th scope="col">Aksi</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($periode as $no =>$item)                      
                      <tr>
                        <th scope="row">{{ $no+1 }}</th>
                        <td>{{ $item->periode }}</td>
                        <td><a href="{{  asset('materi/'.$item->materi)  }}">{{ $item->materi }}</a></td>
                        @if(session('id_role') == 4)
                        <td>
                          <a href="{{ route('edit.periode', $item->id_periode) }}" class="btn btn-info">Edit</a>
                          <a onclick="return confirm('Yakin ingin hapus data ini?')" href="{{ route('delete.periode', $item->id_periode) }}" class="btn btn-danger">Delete</a>                      
                        </td>
                        @endif
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  {{ $periode->links() }}
                </div>
              </div>
            </div>     
        </div>
    </div>
</div>
@endsection
