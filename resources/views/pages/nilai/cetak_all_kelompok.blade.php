<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
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
        <font size="4"><b>SEMESTER {{\Str::upper($periode)}}</b></font>
    </center></td>	  
		<td>
      <br>
      <br>
      @foreach ($nilai as $n => $nn)
      <table style="font-size: 17px;">
        <tr>
          <td>Nama Kelompok</td>
          <td>:</td>
          <td>{{$nn['nama_kelompok']}}</td>
        </tr>
        @foreach ($nn['mentor'] as $item)
        <tr>
            <td>Nama Mentor {{$loop->iteration}}</td>
            <td>:</td>
            <td>{{\Str::ucfirst($item->nama_mhs)}}</td>
          </tr>
        @endforeach
          <tr>
            <td>Jumlah Mahasiswa</td>
            <td>:</td>
            <td>{{$nn['jml_mhs']}}</td>
          </tr>
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
                          <th rowspan="2">Nilai Pendalaman Materi</th>
                          <th colspan="2">Nilai Ujian Praktek BBQ (25%)</th>
                          <th colspan="2">Nilai Ujian Praktek Ibadah (25%)</th>
                          <th rowspan="2">Akhlak</th>
                          <th rowspan="2">Total Nilai</th>
                        </tr>
                        <tr class="text-center">
                          <th>Hadir</th>
                          <th>Izin</th>
                          <th>Alfa</th>
                          <th>Pertemuan Mentoring</th>
                          <th>Ujian Praktek</th>
                          <th>Baca Al-Quran</th>
                          <th>Hafalan</th> 
                          <th>Wudu</th>
                          <th>Shalat</th>
                        </tr>
                      </thead>

                <tbody>
                    @foreach ($nn['data_mhs'] as $item)
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
            <br>
            <br>
            <br>
      @endforeach     
	
<script>
	window.print();
</script>
</body>
</html>