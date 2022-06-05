@extends('layouts.login')
@section('title', 'Login')
@section('content')
<section class="section">
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="login-brand">
          <img src="assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
        </div>

        <div class="card card-primary">
          <div class="card-header"><h4>Login SIPPMAI - UA</h4></div>

          <div class="card-body">
            <form method="POST" action="{{ route('login.submit') }}" class="needs-validation" novalidate="">
              @csrf
              <div class="form-group">
                <label for="email">NIP/NIM</label>
                <input id="nip_nim" type="text" class="form-control" name="nip_nim" tabindex="1" onkeypress="return event.charCode >= 48 && event.charCode <=57" required autofocus>
                <div class="invalid-feedback">
                  please fill in your NIP/NIM
                </div>
              </div>
              <div class="form-group">
                <div class="d-block">
                  <label for="password" class="control-label">Password</label>
                </div>
                <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                <div class="invalid-feedback">
                  please fill in your password
                </div>
              </div>           
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block"  tabindex="4">
                  Login
                </button>
              </div>
            </form>
          </div>
        </div>       
      </div>
    </div>
  </div>
</section>
@endsection

