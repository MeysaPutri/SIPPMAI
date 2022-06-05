@extends('layouts.master')
@section('title', 'Tambah Laporan')
@section('section-header')
<div class="section-header">
    <h1>Tambah Laporan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('laporan') }}">Laporan</a></div>
      <div class="breadcrumb-item">Tambah</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
  <form action="{{ route('submit.laporan') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <form class="needs-validation" novalidate="">
              <div class="card-body">
                @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible show fade">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="form-group">
                  <label>Periode</label>
                  <select name="id_periode" class="form-control select2" required="">
                    @foreach($periode as $item)
                      <option value="{{ $item->id_periode }}">{{ $item->periode }}</option>
                    @endforeach
                  </select>
                </div> 
                <div class="form-group">
                  <label>Nama Mentor</label>
                  <select name="nim" class="form-control select2" required="">
                      <option value="{{ $mentor->nim }}">{{ $mentor->nama_mhs }}</option>
                    {{-- <script>
                      document.getElementById('nim').value = "{{ Request::get('nim') }}"
                    </script> --}}
                  </select>
                </div>
                <div class="form-group">
                  <label>Nama Kelompok</label>
                  <select name="id_kel" id="id_kel" class="form-control select2" required="">
                      <option value="">Pilih Kelompok</option>
                    @foreach($kelompok as $item)
                      <option value="{{ $item->id_kel }}">{{ $item->nama_kel }}</option>
                    @endforeach
                  </select>
                </div> 
                <div class="form-group">
                  <label>Pertemuan</label>
                  <select name="id_pertemuan" id="id_pertemuan" class="form-control select2" required="">
                      <option value="">Pilih Pertemuan</option>                      
                      @for ($i=1;$i<count($pertemuan)+1;$i++){
                        echo '<option value="{{$i}}">
                          {{$i}}
                        </option>';
                      }  
                      @endfor                      
                  </select>
                </div>                
                <div class="form-group">
                  <label>Tanggal</label>
                  <input type="date" name="tgl" class="form-control" required="">
                </div>
                <div class="form-group">
                  <label>Laporan</label>
                  <textarea type="text" name="laporan" id="laporan" class="form-control" required=""></textarea>
                </div>
                <div class="form-group">
                  <label>Keterangan</label>
                  <input type="text" name="keterangan" class="form-control" required="">                  
                </div>
                <div class="form-group">
                  <label>Jumlah mentee dalam kelompok yang hadir</label>
                  <select name="mentee_hadir" id="mentee_hadir" class="form-control select2" required="">
                    <option value="">Pilih jumlah mentee yang hadir</option>
                  </select>
                </div> 
                <div class="form-group">
                  <label>Gambar</label>
                  <input type="file" name="gambar" class="form-control" required="">
                </div>
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-primary mr-1" type="submit">Submit</button>
              </div>
            </form>
          </div>
      </div>
  </form>
</div>

@push('after-scripts')
<script>
  $(document).ready(function () {
      $('#id_kel').change(function(e){
        $('#mentee_hadir').html('');
        e.preventDefault()
        var id_kel = $(this).val();
        if(id_kel == ''){
          alert('Pilih kelompok terlebih dahulu')
        }else{
          $.ajax({
            type: "POST",
            url: "{{route('dropdown.laporan')}}",
            data: {
              _token: '{{csrf_token()}}',
              id_kel:id_kel
              },
            dataType: "json",
            success: function (res) {
              console.log(res) 
              if(res.pesan == 'ok'){
                var mentee = '';
                var i;
                for(i=0;i<=res.mentee.length;i++){
                  mentee += `<option value='`+[i]+`'>`+[i]+`</option>`
                }
                $('#mentee_hadir').append(mentee);
              }
            }
          });
        }
      })
    });
</script>
@endpush
@endsection