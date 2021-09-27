<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="index.html">SIPPMAI</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">Mt</a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Menu Utama</li>
        <li class="dropdown"> 
            <li><a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>
        </li>
        <li class="menu-header">Kelola Data Mentoring</li>
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-user-alt"></i><span>Data User</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('mentor') }}">Mentor</a></li>
            <li><a class="nav-link" href="{{ route('mentee') }}">Mentee</a></li>
            <li><a class="nav-link" href="{{ route('dosen') }}">Dosen PAI</a></li>
          </ul>
        </li>
        <li class=menu><a class="nav-link" href="{{ route('kelompok') }}"><i class="fas fa-user-friends"></i><span>Kelompok</span></a></li>
        <li class=menu><a class="nav-link" href="{{ route('kelas') }}"><i class="fas fa-users"></i> <span>Kelas</span></a></li>
        <li class="menu-header">Kelola Kegiatan Mentoring</li>
        <li><a class="nav-link" href="{{ route('amalan') }}"><i class="fas fa-book-open"></i><span>Amalan Yaumi</span></a></li> 
        <li><a class="nav-link beep beep-sidebar" href="{{ route('materi') }}"><i class="far fa-file-alt"></i><span>Materi</span></a></li>  
        <li class="menu-header">Kelola Penilaian Mentoring</li>
        <li><a href="{{ route('penilaian') }}"><i class="far fa-star"></i><span>Penilaian Mentoring</span></a></li> 
      <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
        <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
          <i class="fas fa-rocket"></i> Documentation
        </a>
      </div>        </aside>
  </div>