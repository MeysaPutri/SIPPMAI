@extends('layouts.master')
@section('title', 'Cetak SCM')
@section('section-header')
<div class="section-header">
    <h1>Cetak Suplemen Calon Mentor</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item active"><a href="{{ route('scm') }}">Suplemen Calon Mentor</a></div>
      <div class="breadcrumb-item a">Cetak Suplemen Calon Mentor</div>
    </div>
</div>    
@endsection
@section('content')

<div class="section-body">
    <div class="row"> 
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                  <form action="{{route('cetak.scm.store')}}" method="post">
                      @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Berdasarkan</label>
                            <select name="key" id="key" class="form-control select2" required="" style="width: 100%">
                                  <option value="">Pilih</option>
                                  <option value="all">Tampilkan semua</option>
                                  <option value="approve">Approve</option>
                                  <option value="disapprove">Disapprove</option>
                                  <option value="in review">In Review</option>
                            </select>                  
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Periode</label>
                          @php
                              $periode = DB::table('periodes')->get();
                          @endphp
                            <select name="id_periode" id="id_periode" class="form-control select2" required="" style="width: 100%">
                                  <option value="">Pilih Periode</option>
                                  @foreach ($periode as $item)
                                  <option value="{{$item->id_periode}}">{{$item->periode}}</option>
                                  @endforeach
                            </select>                  
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>&nbsp;</label>
                         <button type="submit" class="btn btn-primary btn-block">Cetak Suplemen Calon Mentor</button>     
                        </div>
                      </div>
                </div>
                </form>
              </div>
            </div>     
        </div>
    </div>
</div>
@endsection

