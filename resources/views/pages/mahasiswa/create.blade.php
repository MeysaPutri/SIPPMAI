@extends('layouts.master')
@section('title', 'Tambah Mahasiswa')
@section('section-header')
<div class="section-header">
    <h1>Tambah Mahasiswa</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Data User</a></div>
      <div class="breadcrumb-item"><a href="{{ route('mahasiswa') }}">Mahasiswa</a></div>
      <div class="breadcrumb-item">Tambah</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
  <form action="{{ route('submit.mahasiswa') }}" method="POST">
      @csrf
      @if (count($errors) > 0)
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
        @endif
      <div class="row">        
          <div class="col-12 col-md-12 col-lg-12">
            <form class="needs-validation" novalidate="">
              <div class="card-body"> 
                  <div class="form-group">
                    <label>NIM</label>
                    <input type="text" name="nim" class="form-control" required="">
                  </div>
                  <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama_mhs" class="form-control" required="">
                  </div>
                  <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required="">
                        <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                    </select>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" required="">
                      </div> 
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control" required="">
                      </div>
                    </div>
                  </div>                  
                  <div class="form-group">
                    <label>Fakultas</label>
                    @php
                        $fakultas = DB::table('fakultas')->get();
                    @endphp
                    <select name="id_fakultas" id="id_fakultas" class="form-control select2" required="">
                        <option value="">Pilih Fakultas</option>
                        @foreach ($fakultas as $item)
                          <option value="{{$item->id_fakultas}}">
                              {{$item->nama_fakultas}}
                          </option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Jurusan</label>
                    <select name="id_jurusan" id="id_jurusan" class="form-control select2" required="">
                        <option value="">Pilih Jurusan</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Alamat</label>
                    <textarea type="text" name="alamat" class="form-control" required=""></textarea>
                  </div>
                  <div class="form-group">
                    <label>No. HP</label>
                    <input type="text" name="no_hp" class="form-control" required="">
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required="">
                  </div>
                  <div class="form-group">
                    <label>Golongan Darah</label>
                    <input type="text" name="gol_dar" class="form-control" required="">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required="">
                  </div>
              </div>
            </form>
            <div class="card-footer text-right">
                <button class="btn btn-primary mr-1" type="submit">Submit</button>
            </div>
          </div>
      </div>
  </form>
</div>

@push('page-scripts')
    <script>
      $(document).ready(function () {
          $('#id_fakultas').change(function(e){
            $('#id_jurusan').html('pilih jurusan');
            e.preventDefault()
            var id_fakultas = $(this).val();
            if(id_fakultas == ''){
              alert('Pilih fakultas terlebih dahulu')
            }else{
              $.ajax({
                type: "POST",
                url: "{{route('api_fakultas.mahasiswa')}}",
                data: {
                  _token: '{{csrf_token()}}',
                  id_fakultas:id_fakultas
                  },
                dataType: "json",
                success: function (res) {
                  if(res.pesan == 'ok'){
                    var baris = '';
                    var i;
                    for(i=0;i<res.jurusan.length;i++){
                      baris += `<option value='`+res.jurusan[i].id_jurusan+`'>`+ res.jurusan[i].nama_jurusan.toUpperCase() +`</option>`
                    }
                    $('#id_jurusan').append(baris);
                  }
                }
              });
            }
          })
        });
    </script>
@endpush
 
@endsection

