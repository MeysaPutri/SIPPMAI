<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
      <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
      </ul>
    </form>
    <ul class="navbar-nav navbar-right">
      @if (session('id_role') == 2 || session('id_role') == 1 || session('id_role') == 4)     
            @if(session('id_role') == 2)
              @php
                $periode = DB::table('periodes')->max('id_periode');
                $id_dosen = DB::table('dosens')->where('nip', session('nip_nim'))->first()->nip;
                //hitung jumlah mentee berdasarkan kelas dosen
                $jumlah_mentee = DB::table('detail_kelas')
                  ->leftJoin('mahasiswas', 'detail_kelas.nim', '=', 'mahasiswas.nim')
                  ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                  ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                  ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                  ->where('kelas.id_periode', $periode)
                  ->where('dosens.nip', $id_dosen)
                  ->where('detail_kelas.nim', '!=', NULL)
                  ->select('detail_kelas.nim')
                  ->count();
                //hitung jumlah nilai mentee yg sudah di input berdasarkan kelas dosen
                $jumlah_nilai_mentee =  DB::table('nilai_mentorings')
                  ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                  ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                  ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                  ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                  ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                  ->where('kelas.id_periode', $periode)
                  ->where('dosens.nip', $id_dosen)
                  ->where('nilai_mentorings.nim', '!=', NULL)
                  ->select('nilai_mentorings.nim')
                  ->count();
              @endphp
              @if ($jumlah_mentee == $jumlah_nilai_mentee)
              <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
                <div class="dropdown-menu dropdown-list dropdown-menu-right">
                  <div class="dropdown-header">Notifications</div>
                  <div class="dropdown-list-content dropdown-list-icons">
                    <a href="{{route('nilai', ['id_periode'=>$periode])}}" class="dropdown-item">
                      <div class="dropdown-item-icon bg-info text-white">
                        <i class="fas fa-bell"></i>
                      </div>
                      <div class="dropdown-item-desc">
                        Nilai mentoring sudah lengkap, silahkan cek nilai mahasiswa di kelas anda
                      </div>
                    </a>
                  </div>
                </div>
              </li>
              @endif
            @endif
            @if(session('id_role') == 4)
              @php  
                //apabila periode merupakan max periode, tampilkan notifikasi         
                $periode = DB::table('periodes')->max('id_periode');

                //hitung jumlah mentee
                $jumlah_seluruh_mentee = DB::table('detail_mentees')
                  ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                  ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                  ->where('kelompoks.id_periode', $periode)
                  ->select('detail_mentees.nim')->count();
                //hitung jumlah nilai mentee
                $jumlah_seluruh_nilai_mentee = DB::table('nilai_mentorings')
                  ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                  ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                  ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                  ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                  ->where('kelompoks.id_periode', $periode)
                  ->select('nilai_mentorings.nim')->count(); 
                
                //hitung jumlah detail_kelas.nim
                $detail_kelas = DB::table('detail_kelas')
                  ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                  ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                  ->where('kelas.id_periode', $periode)
                  ->select('detail_kelas.nim')->count();
                //hitung jumlah detail_mentees.nim
                $detail_mentee = DB::table('detail_mentees')
                  ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                  ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                  ->where('kelompoks.id_periode', $periode)
                  ->select('detail_mentees.nim')->count();
                
                //hitung jumlah detail_mentee yg memenuhi kriteria SCM
                $mentee_scm = DB::table('nilai_mentorings') 
                    ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                    ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                    ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                    ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                    ->leftJoin('users', 'mahasiswas.nim', '=', 'users.nip_nim')
                    ->select('detail_mentees.*', 'periodes.*', 'mahasiswas.*', 'users.*')
                    ->where('kelompoks.id_periode', $periode)        
                    ->where('nilai_mentorings.hadir', '>=', 6)
                    ->select(
                      'nilai_mentorings.*',
                      'mahasiswas.*',
                      'detail_mentees.*',
                      'kelompoks.*',
                      'periodes.*',
                      'users.*'
                      )
                    ->count();   
                //hitung mentee di SCM 
                $seluruh_scm = DB::table('scms')
                    ->leftJoin('mahasiswas', 'scms.nim', '=', 'mahasiswas.nim')
                    ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                    ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                    ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                    ->where('kelompoks.id_periode', $periode)      
                    ->select('scms.nim')
                    ->count();                    
              @endphp

              <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
                <div class="dropdown-menu dropdown-list dropdown-menu-right">
                  <div class="dropdown-header">Notifications</div>
                  <div class="dropdown-list-content dropdown-list-icons">
                    @if ($jumlah_seluruh_mentee == $jumlah_seluruh_nilai_mentee)
                      <a href="{{route('nilai', ['id_periode'=>$periode])}}" class="dropdown-item">
                        <div class="dropdown-item-icon bg-info text-white">
                          <i class="fas fa-bell"></i>
                        </div>
                        <div class="dropdown-item-desc">
                          Nilai mentoring semua mentee sudah lengkap, silahkan cetak nilai mentoring mentee
                        </div>
                      </a>
                    @endif
                    @if ($detail_mentee == $detail_kelas)                    
                      <a href="{{route('kelompok', ['id_periode'=>$periode])}}" class="dropdown-item">
                        <div class="dropdown-item-icon bg-info text-white">
                          <i class="fas fa-bell"></i>
                        </div>
                        <div class="dropdown-item-desc">
                          Data sudah lengkap, akun mentee sudah dapat disebarkan
                        </div>
                      </a>                    
                    @endif
                    @if ($mentee_scm == $seluruh_scm)                    
                      <a href="{{route('scm', ['id_periode'=>$periode])}}" class="dropdown-item">
                        <div class="dropdown-item-icon bg-info text-white">
                          <i class="fas fa-bell"></i>
                        </div>
                        <div class="dropdown-item-desc">
                          Seluruh mentee yang memenuhi kriteria SCM sudah mengisi persetujuan SCM, silahkan diperiksa daftarnya
                        </div>
                      </a>                    
                    @endif
                  </div>
                </div>
              </li>
            @endif
            @if(session('id_role') == 1)
              @php  
                //apabila periode merupakan max periode, tampilkan notifikasi         
                $periode = DB::table('periodes')->max('id_periode');
                //menentukan mentor 
                $mentor = DB::table('detail_mentors')->where('nim', session('nip_nim'))->first()->nim;

                //hitung jumlah detail_mentee yg memenuhi kriteria SCM
                $mentee_kelompok = DB::table('nilai_mentorings') 
                    ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                    ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                    ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                    ->leftJoin('detail_mentors', 'kelompoks.id_kel', '=', 'detail_mentors.id_kel')
                    ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                    ->leftJoin('users', 'mahasiswas.nim', '=', 'users.nip_nim')
                    ->select('detail_mentees.*', 'periodes.*', 'mahasiswas.*', 'users.*')
                    ->where('kelompoks.id_periode', $periode)
                    ->where('detail_mentors.nim', $mentor)
                    ->where('nilai_mentorings.hadir', '>=', 6)
                    ->select(
                      'nilai_mentorings.*',
                      'mahasiswas.*',
                      'detail_mentees.*',
                      'detail_mentors.*',
                      'kelompoks.*',
                      'periodes.*',
                      'users.*'
                      )
                    ->count();   
                //hitung mentee di SCM 
                $scm_kelompok = DB::table('scms')
                    ->leftJoin('mahasiswas', 'scms.nim', '=', 'mahasiswas.nim')
                    ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                    ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                    ->leftJoin('detail_mentors', 'kelompoks.id_kel', '=', 'detail_mentors.id_kel')
                    ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                    ->where('kelompoks.id_periode', $periode) 
                    ->where('detail_mentors.nim', $mentor)     
                    ->select('scms.nim')
                    ->count();                    
              @endphp

              <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
                <div class="dropdown-menu dropdown-list dropdown-menu-right">
                  <div class="dropdown-header">Notifications</div>
                  <div class="dropdown-list-content dropdown-list-icons">                    
                    @if ($mentee_kelompok == $scm_kelompok)                    
                      <a href="{{route('scm', ['id_periode'=>$periode])}}" class="dropdown-item">
                        <div class="dropdown-item-icon bg-info text-white">
                          <i class="fas fa-bell"></i>
                        </div>
                        <div class="dropdown-item-desc">
                          Seluruh mentee yang memenuhi kriteria SCM dalam kelompok Anda sudah mengisi persetujuan SCM, silahkan diperiksa daftarnya
                        </div>
                      </a>                    
                    @endif
                  </div>
                </div>
              </li>
            @endif
          
      @endif
     
      <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
        @php
            $user = DB::table('users')->where('nip_nim', session('nip_nim'))->first();
        @endphp
        <div class="d-sm-none d-lg-inline-block">Hi, {{\Str::ucfirst($user->name)}}</div></a>
        <div class="dropdown-menu dropdown-menu-right">
          @if(session('id_role') != 4)
          <a href="{{ route('profile') }}" class="dropdown-item has-icon">
            <i class="far fa-user"></i> Profile
          </a>
          @endif
          @if (session('id_role') == 4)
          <a href="{{ route('reset') }}" class="dropdown-item has-icon">
            <i class="fas fa-cog"></i> Reset Password
          </a>
          @endif
          <div class="dropdown-divider"></div>
          <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>