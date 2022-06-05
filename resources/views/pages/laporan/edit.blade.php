@extends('layouts.master')
@section('title', 'Edit Laporan')
@section('section-header')
<div class="section-header">
    <h1>Edit Laporan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('laporan') }}">Laporan</a></div>
      <div class="breadcrumb-item">Edit</div>
    </div>
</div>    
@endsection
@section('content')
<div class="section-body">
  <form action="{{ route('update.laporan', $laporan->id_laporan) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('patch')
      <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
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
                  <input type="text" name="nim"  
                  @if (old('nim'))
                  value="{{ (old('nim')) }}"
                  @else
                  value="{{ $laporan->nama_mhs }}" 
                  @endif
                  {{session('id_role') == 1 ? 'disabled' : ''}}
                  class="form-control">
                </div>
                <div class="form-group">
                  <label>Nama Kelompok</label>
                  <select name="id_kel" id="id_kel" class="form-control select2" required="">              
                    @foreach($kelompok as $item)
                      <option value="{{ $item->id_kel }}" <?= $item->id_kel == $single_kelompok->id_kel ? 'selected' : '' ?>>
                        {{ $item->nama_kel }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Pertemuan</label>
                  <select name="id_pertemuan" class="form-control" required="">
                      <option value="">Pilih Pertemuan</option>
                      @php
                      $pertemuan = DB::table('laporans')
                        ->leftJoin('mahasiswas', 'laporans.nim', 'mahasiswas.nim')
                        ->leftJoin('detail_mentors', 'mahasiswas.nim', '=', 'detail_mentors.nim')
                        ->leftJoin('pertemuans', 'laporans.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                        ->select('laporans.id_pertemuan')
                        ->groupBy('laporans.id_pertemuan')
                        ->havingRaw('laporans.id_pertemuan' > 1)
                        ->get();
                      @endphp
                      
                      @for ($i=1;$i<=count($pertemuan)+1;$i++)
                      {
                        echo '<option value="{{$i}}">
                          {{$i}}
                        </option>';
                      }  
                      @endfor  
                  </select>
                </div>              
                <div class="form-group">
                  <label>Tanggal</label>
                  <input type="date" name="tgl"  
                  @if (old('tgl'))
                    value="{{ (old('tgl')) }}"
                  @else
                    value="{{ $laporan->tgl }}"
                  @endif
                  class="form-control">
                </div>
                <div class="form-group">
                  <label>Laporan</label>
                  <textarea type="text" name="laporan" id="laporan"  class="form-control">
                    @if (old('laporan'))
                      {{ (old('laporan')) }}
                    @else
                      {{ $laporan->laporan }}
                    @endif
                  </textarea>
                </div>                
                <div class="form-group">
                  <label>Keterangan</label>
                  <input type="text" name="keterangan"  
                  @if (old('keterangan'))
                    value="{{ (old('keterangan')) }}"
                  @else
                    value="{{ $laporan->keterangan }}"
                  @endif
                    class="form-control">
                </div>
                <div class="form-group">
                  <label>Jumlah mentee dalam kelompok yang hadir</label>
                  <select name="mentee_hadir" id="mentee_hadir" class="form-control select2" required="">
                    @for ($i=0;$i<=count($mentee);$i++)
                    {
                      echo '<option value="{{$i}}" <?= $i==$laporan->mentee_hadir ?'selected' :'' ?>>
                        {{$i}}
                      </option>';
                    }  
                    @endfor      
                  </select>
                </div> 
                <div class="form-group">
                  <label>Gambar</label>
                  <input type="file" class="form-control" id="gambar" name="gambar">
                  <br><br>
                  @if($laporan->gambar)
                  <a href="{{ asset('gambar/'.$laporan->gambar) }}">
                           {{ $laporan->gambar }}
                  </a>
                  <input type="hidden" name="gambarOld" value="{{ $laporan->gambar }}"class="form-control">
                  @else
                    <p>Kamu belum punya gambar</p>
                  @endif                     
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
  document.getElementsByName('id_pertemuan')[0].value ="{{ $laporan->id_pertemuan}}"
  document.getElementsByName('mentee_hadir')[0].value ="{{ $laporan->mentee_hadir}}"
  document.getElementsByName('id_kel')[0].value ="{{ $laporan->id_kel}}"
</script>

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

