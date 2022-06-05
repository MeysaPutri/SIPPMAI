@extends('layouts.login')
@section('title', 'Reset Password')
@section('content')
<section class="section">
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="login-brand">
          <img src="assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
        </div>

        <div class="card card-primary">
          <div class="card-header"><h4>Reset Password</h4></div>

          <div class="card-body">
            <p class="text-muted">Change the user's password here</p>
            <form method="POST" action="{{ route('reset.password') }}" class="needs-validation" novalidate="">
              @csrf
              <div class="form-group">
                <label for="email">NIP/NIM</label>
                @php
                    $nip_nim = DB::table('users')
                    ->select('nip_nim')
                    ->get();
                @endphp
                <select name="nip_nim" id="nip_nim" class="form-control select2" required="" style="width: 100%">
                  <option value="">Pilih</option>
                  @foreach ($nip_nim as $item)
                      <option value="{{$item->nip_nim}}">
                          {{$item->nip_nim}}
                      </option>
                  @endforeach
              </select> 
              </div>
              <div class="form-group">
                <label >Nama</label>
                <input type="name" id="name" class="form-control" name="name" readonly>
              </div>
              <div class="form-group">
                <label for="password">New Password</label>
                <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" tabindex="2" required>
                <div id="pwindicator" class="pwindicator">
                  <div class="bar"></div>
                  <div class="label"></div>
                </div>
              </div>
             
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                  Reset Password
                </button>
                <a href="{{route('dashboard')}}" class="btn btn-warning btn-lg btn-block">Kembali</a>
              </div>
            </form>
          </div>
        </div>
        <div class="simple-footer">
          Copyright &copy; Stisla 2021
        </div>
      </div>
    </div>
  </div>
</section>
@push('after-scripts')
    <script>
     $(document).ready(function () {
       $('#nip_nim').change(function(e){
        $('#name').val('')
         e.preventDefault()
         var nip_nim = $(this).val()
         if(nip_nim == ''){
           alert('pilih nip/nim terlebih dahulu');
         }else{
           $.ajax({
             type: "POST",
             url: "{{route('api.reset')}}",
             data: {
                  _token: '{{csrf_token()}}',
                  nip_nim:nip_nim
                  },
             dataType: "json",
             success: function (res) {
               console.log(res)
               $('#name').val(res.user.name)
             }
           });
         }
       })
     });
    </script>
@endpush
@endsection

