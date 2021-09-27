@extends('layouts.master')
@section('title', 'Dashboard')
@section('section-header')
<div class="section-header">
    <h1>Dashboard</h1>
</div>    
@endsection
@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-primary">
                <i class="far fa-user"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Mentor</h4>
                </div>
                <div class="card-body">
                  10
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-danger">
                <i class="far fa-newspaper"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Mentee</h4>
                </div>
                <div class="card-body">
                  42
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-warning">
                <i class="far fa-file"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Dosen PAI</h4>
                </div>
                <div class="card-body">
                  1,201
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-success">
                <i class="fas fa-circle"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Kelompok</h4>
                </div>
                <div class="card-body">
                  47
                </div>
              </div>
            </div>
          </div>
    </div>
</div>


@endsection

