@extends('layouts.master')
@section('title', 'Profile')
@section('section-header')
<div class="section-header">
    <h1>Profile</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Profile</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
    @php
        $user = DB::table('users')
          ->leftJoin('roles', 'users.id_role', '=', 'roles.id_role')
          ->leftJoin('dosens', 'users.nip_nim', '=', 'dosens.nip')
          ->select('roles.*', 'users.*', 'dosens.*',
            'dosens.no_hp as no_hpdosen', 'dosens.email as emaildosen')
          ->where('nip_nim', session('nip_nim'))->first();
        $mentor = DB::table('detail_mentors')
          ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
          ->leftJoin('users', 'mahasiswas.nim', '=', 'users.nip_nim')
          ->select('users.*', 'detail_mentors.*', 'mahasiswas.*', 
            'mahasiswas.no_hp as no_hpmentor', 'mahasiswas.email as emailmentor')
          ->where('nip_nim', session('nip_nim'))->first();
        $mentee = DB::table('detail_mentees')
          ->leftJoin('mahasiswas', 'detail_mentees.nim', '=', 'mahasiswas.nim')
          ->leftJoin('users', 'mahasiswas.nim', '=', 'users.nip_nim')
          ->select('users.*', 'detail_mentees.*', 'mahasiswas.*', 
            'mahasiswas.no_hp as no_hpmentee', 'mahasiswas.email as emailmentee')
          ->where('nip_nim', session('nip_nim'))->first();
    @endphp
    <h2 class="section-title">Hi, {{\Str::ucfirst($user->name)}}!</h2>
    <p class="section-lead">
      Change information about yourself on this page.
    </p>

    <div class="row mt-sm-4">
      <div class="col-12">
        <div class="card profile-widget">
          <div class="profile-widget-header">                     
            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle profile-widget-picture">
            <div class="profile-widget-items">
              <div class="profile-widget-description">
                
                <div class="profile-widget-name">{{\Str::ucfirst($user->name)}}<div class="text-muted d-inline font-weight-normal"><div class="slash"></div> {{ \Str::ucfirst($user->nama_role) }}</div></div>
              </div>
            </div>
          </div>
            <form action="{{route('update.profile')}}" method="post" class="needs-validation" novalidate="">     
              @csrf          
              <div class="card-body">
                  <div class="row">                               
                    <div class="form-group col-md-5 col-12">                      
                      <label>
                        @if(session('id_role')==2)
                          NIP
                        @else
                          NIM
                        @endif
                      </label>
                      <input type="text" name="nip_nim" class="form-control" value="{{ $user->nip_nim }}" required="" readonly>
                      <div class="invalid-feedback">
                        Please fill in the NIP/NIM
                      </div>
                    </div>
                    <div class="form-group col-md-7 col-12">
                      <label>Nama</label>
                      <input type="text" name="name" class="form-control" value="{{\Str::ucfirst($user->name)}}" required="">
                      <div class="invalid-feedback">
                        Please fill in the Name
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6 col-12">
                      <label>No. Hp</label>
                      <input type="text" name="no_hp" class="form-control" value="
                      @if(session('id_role') == 2)
                        {{ $user->no_hpdosen }}
                      @elseif(session('id_role') == 1)
                        {{ $mentor->no_hpmentor }}
                      @elseif(session('id_role') == 3) 
                        {{ $mentee->no_hpmentee }} 
                      @endif
                      " required="">
                      <div class="invalid-feedback">
                        Please fill in the phone
                      </div>
                    </div>
                    <div class="form-group col-md-6 col-12">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" value="
                      @if(session('id_role') == 2)
                        {{ $user->emaildosen }}
                      @elseif(session('id_role') == 1)
                        {{ $mentor->emailmentor }}
                      @elseif(session('id_role') == 3) 
                        {{ $mentee->emailmentee }} 
                      @endif
                      " required="">
                      <div class="invalid-feedback">
                        Please fill in the email
                      </div>
                    </div>                    
                  </div>
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-primary">Save Changes</button>
              </div>
            </form>                     
        </div>
      </div>      
    </div>
  </div>
@endsection