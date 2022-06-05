<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> --}}
	<title>Document</title>
</head>
<body style="font-size: 14px">
<table align="center">
	{{-- membuat kop nama kampus --}}
	<br>
	<td><img src="{{asset('assets/img/Logo_Unand.png')}}" alt="" style="width: 90px; height:90px; margin-right:20px;margin-top:-20px;" ></td>
	<td><center>
		<font size="6"><b>UNIVERSITAS ANDALAS</b></font><br>
		<font size="5"><b>KAMPUS MERDEKA BELAJAR </b></font><br>
	  </center></td>
</table>	
	<hr style="border-bottom:1px solid black; width:80%;">
		<br>
	
		<td><center>
		    <font size="4"><b>REKAP NILAI MENTORING </b></font>
		</center></td>
        <td><center>
			
            <font size="4"><b>SEMESTER {{\Str::upper($periode->periode)}}</b></font>
       </center></td>	  
		<td>
      <br>
      <table style="font-size: 17px;">
        @if (isset($ket1))
        <tr>
          <td>{{$ket1 ?? ''}}</td>
          <td>{{isset($ket1) ? ':':''}}</td>
          <td>{{$val1 ?? ''}}</td>
        </tr>
        @endif
        @if (isset($mentor))
        @foreach ($mentor as $item)
        <tr>
          <td>Nama Mentor {{$loop->iteration}}</td>
          <td>{{isset($mentor) ? ':':''}}</td>
          <td>{{\Str::ucfirst($item->nama_mhs)}}</td>
        </tr>
        @endforeach
        @endif
        @if (isset($ket2))
        <tr>
          <td>{{$ket2 ?? ''}}</td>
          <td>{{isset($ket2) ? ':':''}}</td>
          <td>{{$val2 ?? ''}}</td>
        </tr>
        @endif
        @if (isset($ket3))
        <tr>
          <td>{{$ket3 ?? ''}}</td>
          <td>{{isset($ket3) ? ':':''}}</td>
          <td>{{$val3 ?? ''}}</td>
        </tr>
        @endif
       
      </table>
    
		</td>
	<br>
            <table border="1" width="100%">
               
                    <thead>
                        <tr class="text-center">
                          <th rowspan="2">No</th>
                          <th rowspan="2">Nim</th>
                          <th rowspan="2">Nama</th>
                          <th rowspan="2">Fakultas</th>
                          <th colspan="4">Kehadiran (20%)</th>
                          <th rowspan="2">Nilai Pendalaman Materi (20%)</th>
                          <th colspan="2">Nilai Ujian Praktek BBQ (25%)</th>
                          <th colspan="2">Nilai Ujian Praktek Ibadah (25%)</th>
                          <th rowspan="2">Akhlak (10%)</th>
                          <th rowspan="2">Total Nilai</th>
                        </tr>
                        <tr class="text-center">
                          <th>Hadir</th>
                          <th>Izin</th>
                          <th>Alfa</th>
                          <th>Ujian Praktek</th>
                          <th>Baca Al-Quran</th>
                          <th>Hafalan</th>
                          <th>Wudu</th>
                          <th>Shalat</th>
                        </tr>
                      </thead>
                <tbody>
                    @foreach ($nilai as $item)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$item->nim}}</td>
                        <td>{{$item->nama_mhs}}</td>
                        <td>{{$item->nama_fakultas}}</td>
                        <td style="text-align: center">{{ $item->hadir }}</td>
                        <td style="text-align: center">{{ $item->izin }}</td>
                        <td style="text-align: center">{{ $item->alfa }}</td>
                        <td style="text-align: center">{{ $item->pertemuan_ujian }}</td>
                        <td style="text-align: center">{{ $item->npendalaman_materi }}</td>
                        <td style="text-align: center">{{ $item->baca_alquran }}</td>
                        <td style="text-align: center">{{ $item->hafalan }}</td>
                        <td style="text-align: center">{{ $item->wudu }}</td>
                        <td style="text-align: center">{{ $item->shalat }}</td>
                        <td style="text-align: center">{{ $item->akhlak }}</td>
                        <td style="text-align: center">{{ $item->total_nilai }}</td>
                    </tr>
                    @endforeach
                </tbody>        
            </table>	
    <script>
		window.print();
	</script>
	{{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script> --}}
</body>

</html>