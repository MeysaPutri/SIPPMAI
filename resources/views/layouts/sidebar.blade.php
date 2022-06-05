<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="/">SIPPMAI - UA</a>
        @php
            $roles = DB::table('users')
            ->join('roles', 'users.id_role', '=', 'roles.id_role')
            ->where('users.nip_nim', session('nip_nim'))
            ->first();
        @endphp
        <p><span class="badge badge-primary">Roles : {{\Str::ucfirst($roles->nama_role)}}</span></p>
        
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="/">SM</a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Menu Utama</li>
        <li class="dropdown"> 
            <li><a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>
        </li>

        <li class="menu-header">Kelola Data Mentoring</li>
        @if(session()->get('id_role') == 4||session()->get('id_role') == 1)
        <li class=menu><a class="nav-link" href="{{ route('periode') }}"><i class="fas fa-hourglass"></i><span>Periode</span></a></li>
        @endif
        
        @if(session()->get('id_role') == 4)
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-user-alt"></i><span>Data User</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('mahasiswa') }}">Mahasiswa</a></li>
            <li><a class="nav-link" href="{{ route('dosen') }}">Dosen PAI</a></li>
          </ul>
        </li>
        @endif

        @php
        $id_kelas = DB::table('mahasiswas')
          ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
          ->where('mahasiswas.nim', session('nip_nim'))->first();
        // if(session('id_role') == 2){
        //   $nip = DB::table('dosens')->where('nip', session('nip_nim'))->first();
        //    $id_kelas = DB::table('kelas')->where('nip', $nip->nip)->first();
        // }elseif (session('id_role') == 3) {
        //  $id_kelas = DB::table('mahasiswas')
        //   ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
        //   ->where('mahasiswas.nim', session('nip_nim'))->first();
        // }            
        @endphp

        @if(session()->get('id_role') == 4 || session()->get('id_role') == 2 || session()->get('id_role') == 3)
        <li class=menu><a class="nav-link" href="         
          @if(session('id_role') == 3)
          {{ route('detail_kelas', $id_kelas->id_kelas) }}
          @else
          {{ route('kelas') }}@endif">
          <i class="fas fa-users"></i> <span>Kelas</span></a>
        </li>
        @endif

        @php
          // $kl_mentor = DB::table('detail_mentors') 
          //   ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
          //   ->where('detail_mentors.nim', session('nip_nim'))
          //   ->first();

            $kl_mentee = DB::table('detail_mentees') 
            ->leftJoin('mahasiswas', 'detail_mentees.nim', '=', 'mahasiswas.nim')
            ->where('detail_mentees.nim', session('nip_nim'))
            ->first();
        @endphp
        
        @if(session()->get('id_role') == 1 || session()->get('id_role') == 3 || session()->get('id_role') == 4)
        <li class=menu><a class="nav-link" href="        
          @if(session('id_role') == 3)
            {{ route('detail_mentee', $kl_mentee->id_kel) }}
          @else
            {{ route('kelompok') }}
          @endif">
          <i class="fas fa-user-friends"></i><span>Kelompok</span></a>
        </li>
        @endif

        @if(session()->get('id_role') == 1 || session()->get('id_role') == 3 ||  session()->get('id_role') == 4)
        <li class="menu-header">Kelola Kegiatan Mentoring</li>
        <li><a class="nav-link" href="{{ route('amalan') }}"><i class="fas fa-book-open"></i><span>Amalan Yaumi</span></a></li> 
        @endif
        
        @if(session()->get('id_role') == 1 || session()->get('id_role') == 4) 
        <li><a class="nav-link" href="{{ route('laporan') }}"><i class="fas fa-sticky-note"></i><span>Laporan Mentoring</span></a></li>   
        @endif

        @if(session()->get('id_role') == 4 || session()->get('id_role') == 1 || session()->get('id_role') == 2)
        <li class="menu-header">Kelola Penilaian Mentoring</li>
        <li><a href="{{ route('nilai') }}"><i class="fas fa-star"></i><span>Nilai Mentoring</span></a></li> 
        @endif
        
        @if(session()->get('id_role') == 4 || session()->get('id_role') == 1)
        <li class="menu-header">Kelola Lainnya</li>
        <li><a href="{{ route('scm') }}"><i class="fas fa-archive"></i><span>Suplemen Calon Mentor</span></a></li> 
        @endif
    </aside>
  </div>