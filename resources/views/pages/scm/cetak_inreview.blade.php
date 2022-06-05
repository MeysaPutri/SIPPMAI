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
		    <font size="4"><b>REKAP SUPLEMEN CALON MENTOR </b></font>
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
        @if (isset($ket2))
        <tr>
          <td>{{$ket2 ?? ''}}</td>
          <td>{{isset($ket2) ? ':':''}}</td>
          <td>{{$val2 ?? ''}}</td>
        </tr>
        @endif
       
      </table>
    
		</td>
	<br>
            <table border="1" width="100%">               
                    <thead>
                        <tr class="text-center">
                          <th>No</th>
                          <th>Nim</th>
                          <th>Nama Mentee</th>
                          <th>Fakultas</th>
                          <th>Nama Kelompok</th>
                          <th>Nama Mentor</th>
                          <th>Nama Kelas</th>
                          <th>Nama Dosen</th>
                          <th>Status</th>
                          <th>Alasan Tidak Bersedia</th>
                        </tr>
                      </thead>
                <tbody>
                    @foreach ($scm as $item)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td style="text-align: center">{{$item->nim}}</td>
                        <td style="text-align: center">{{$item->nama_mhs}}</td>
                        <td style="text-align: center">{{$item->nama_fakultas}}</td>
                        <td style="text-align: center">{{ $item->nama_kel }}</td>
                        <td style="text-align: center">
                          @php
                            $detail_mentor = DB::table('detail_mentors')                            
                              ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                              ->select('detail_mentors.nim', 'mahasiswas.nama_mhs')
                              ->where('id_kel', $item->id_kel)
                              ->get();
                          @endphp
                          @foreach($detail_mentor as $key => $data)
                            Mentor {{ $key+1 }} : {{ $data->nama_mhs }}
                            <br>
                          @endforeach
                        </td>
                        <td style="text-align: center">{{ $item->nama_kelas }} - {{ $item->sks }}</td>
                        <td style="text-align: center">{{ $item->nama_dosen }}</td>
                        <td style="text-align: center">{{ $item->status }}</td>
                        <td style="text-align: center">
                          @if($item->sedia == 1)
                            Tidak ada
                          @else
                            {{ $item->alasan }}
                          @endif
                        </td>
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