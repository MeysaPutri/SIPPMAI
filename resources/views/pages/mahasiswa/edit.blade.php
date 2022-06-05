@extends('layouts.master')
@section('title', 'Edit Mahasiswa')
@section('section-header')
<div class="section-header">
    <h1>Edit Mahasiswa</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Data User</a></div>
      <div class="breadcrumb-item"><a href="{{ route('mahasiswa') }}">Mahasiswa</a></div>
      <div class="breadcrumb-item">Edit</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
  <form action="{{ route('update.mahasiswa', $mahasiswa->nim) }}" method="POST">
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
      @method('patch')        
      <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
              <div class="card-body">                 
                  <div class="form-group">
                    <label>NIM</label>
                    <input type="text" name="nim"  
                    @if (old('nim'))
                      value="{{ (old('nim')) }}"
                    @else
                      value="{{ $mahasiswa->nim }}"
                    @endif
                     class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama_mhs"  
                    @if (old('nama_mhs'))
                      value="{{ (old('nama_mhs')) }}"
                    @else
                      value="{{ $mahasiswa->nama_mhs }}"
                    @endif
                     class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control">
                        <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                    </select>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir"  
                        @if (old('tempat_lahir'))
                          value="{{ (old('tempat_lahir')) }}"
                        @else
                          value="{{ $mahasiswa->tempat_lahir }}"
                        @endif
                        class="form-control">
                      </div> 
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir"  
                        @if (old('tgl_lahir'))
                          value="{{ (old('tgl_lahir')) }}"
                        @else
                          value="{{ $mahasiswa->tgl_lahir }}"
                        @endif
                        class="form-control">
                      </div>
                    </div>
                  </div> 
                  <div class="form-group">
                    <label>Fakultas</label>
                    @php
                    $fakultas = DB::table('fakultas')->get();
                    $single_fakultas = DB::table('fakultas')
                    ->leftJoin('jurusans', 'fakultas.id_fakultas', '=', 'jurusans.id_fakultas')
                    ->where('jurusans.id_jurusan', $mahasiswa->id_jurusan)
                    ->first();
                    @endphp
                    <select name="id_fakultas" id="id_fakultas" class="form-control select2">
                        <option value="">Pilih Fakultas</option>
                        @foreach ($fakultas as $item)
                        <option value="{{$item->id_fakultas}}" <?= $item->id_fakultas == $single_fakultas->id_fakultas ? 'selected' : '' ?>>
                            {{$item->nama_fakultas}}
                        </option>
                      @endforeach
                    </select>
                    <script>
                      // document.getElementsById('id_fakultas').value = 2;
                    </script>
                  </div>
                  <div class="form-group">
                    <label>Jurusan</label>
                    @php
                        $jurusan = DB::table('jurusans')->where('id_fakultas', $single_fakultas->id_fakultas)->get();
                    @endphp
                    <select name="id_jurusan" id="id_jurusan" class="form-control select2">
                        <option value="">Pilih Jurusan</option>
                        @foreach ($jurusan as $item)
                        <option value="{{$item->id_jurusan}}" <?= $item->id_jurusan==$mahasiswa->id_jurusan?'selected' :'' ?>>
                          {{$item->nama_jurusan}}
                        </option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Alamat</label>
                    <textarea type="text" name="alamat" class="form-control">
                      @if (old('alamat'))
                      {{ (old('alamat')) }}
                    @else
                      {{ $mahasiswa->alamat }}
                    @endif
                    </textarea>
                  </div>
                  <div class="form-group">
                    <label>No. HP</label>
                    <input type="text" name="no_hp"  
                    @if (old('no_hp'))
                      value="{{ (old('no_hp')) }}"
                    @else
                      value="{{ $mahasiswa->no_hp }}"
                    @endif
                     class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email"  
                    @if (old('email'))
                      value="{{ (old('email')) }}"
                    @else
                      value="{{ $mahasiswa->emailmahasiswa }}"
                    @endif
                     class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Golongan Darah</label>
                    <input type="text" name="gol_dar"  
                    @if (old('gol_dar'))
                      value="{{ (old('gol_dar')) }}"
                    @else
                      value="{{ $mahasiswa->gol_dar }}"
                    @endif
                     class="form-control">
                  </div>
              </div>
              <div class="card-footer text-right">
                  <button class="btn btn-primary mr-1" type="submit">Save changes</button>
              </div>
          </div>
      </div>
  </form>
</div>
<script>
  document.getElementsByName('jenis_kelamin')[0].value ="{{ $mahasiswa->jenis_kelamin }}"
</script>
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

