<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['belum_login'])->group(function () {
    Route::get('/login', 'LoginController@index')->name('login');
    Route::post('/login', 'LoginController@submit')->name('login.submit');
});

Route::middleware(['sudah_login'])->group(function () {

    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::get('/reset', 'LoginController@reset')->name('reset');
    Route::post('/reset/reset_password', 'LoginController@reset_password')->name('reset.password');
    Route::post('/api-reset', 'LoginController@api_reset')->name('api.reset');


    //route untuk profile
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::post('/profile', 'ProfileController@update')->name('update.profile');

    //route untuk dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');

    //route untuk mahasiswa
    Route::get('/mahasiswa', 'MahasiswaController@index')->name('mahasiswa');
    Route::get('/mahasiswa/create', 'MahasiswaController@create')->name('create.mahasiswa');
    Route::post('/mahasiswa/submit', 'MahasiswaController@submit')->name('submit.mahasiswa');
    Route::get('/mahasiswa/delete/{id}', 'MahasiswaController@delete')->name('delete.mahasiswa');
    Route::get('/mahasiswa/{id}/edit', 'MahasiswaController@edit')->name('edit.mahasiswa');
    Route::patch('/mahasiswa/{id}', 'MahasiswaController@update')->name('update.mahasiswa');
    Route::get('/mahasiswa/{id}/show', 'MahasiswaController@show')->name('show.mahasiswa');
    Route::post('/mahasiswa/api_fakultas', 'MahasiswaController@api_fakultas')->name('api_fakultas.mahasiswa');

    //route untuk dosen
    Route::get('/dosen', 'DosenController@index')->name('dosen');
    Route::get('/dosen/create', 'DosenController@create')->name('create.dosen');
    Route::post('/dosen/submit', 'DosenController@submit')->name('submit.dosen');
    Route::get('/dosen/delete/{id}', 'DosenController@delete')->name('delete.dosen');
    Route::get('/dosen/{id}/edit', 'DosenController@edit')->name('edit.dosen');
    Route::patch('/dosen/{id}', 'DosenController@update')->name('update.dosen');
    Route::get('/dosen/search', 'DosenController@search')->name('search.dosen');

    //route untuk kelompok
    Route::get('/kelompok', 'KelompokController@index')->name('kelompok');
    Route::get('/kelompok/create', 'KelompokController@create')->name('create.kelompok');
    Route::post('/kelompok/submit', 'KelompokController@submit')->name('submit.kelompok');
    Route::get('/kelompok/delete/{id}', 'KelompokController@delete')->name('delete.kelompok');
    Route::get('/kelompok/{id}/edit', 'KelompokController@edit')->name('edit.kelompok');
    Route::post('/kelompok/{id}', 'KelompokController@update')->name('update.kelompok');
    Route::get('/kelompok/search', 'KelompokController@search')->name('search.kelompok');

    //route untuk detail mentee
    Route::get('/kelompok/detail_mentee/{id}', 'DetailMenteeController@index')->name('detail_mentee');
    Route::get('/kelompok/detail_mentee/create/{id}', 'DetailMenteeController@create')->name('create.detail_mentee');
    Route::get('/kelompok/detail_mentee/delete/{id}/{id_kel}', 'DetailMenteeController@delete')->name('delete.detail_mentee');
    Route::post('/kelompok/detail_mentee/submit', 'DetailMenteeController@submit')->name('submit.detail_mentee');
    // Route::get('/kelompok/detail_kelompok/{id}/edit', 'KelompokMenteeController@edit')->name('edit.kelompok_mentee');
    // Route::patch('/kelompok/detail_kelompok/{id}', 'KelompokMenteeController@update')->name('update.kelompok_mentee');

    //route untuk kelas
    Route::get('/kelas', 'KelasController@index')->name('kelas');
    Route::get('/kelas/create', 'KelasController@create')->name('create.kelas');
    Route::post('/kelas/submit', 'KelasController@submit')->name('submit.kelas');
    Route::get('/kelas/delete/{id}', 'KelasController@delete')->name('delete.kelas');
    Route::get('/kelas/{id}/edit', 'KelasController@edit')->name('edit.kelas');
    Route::patch('/kelas/{id}', 'KelasController@update')->name('update.kelas');
    Route::get('/kelas/{id}/show', 'KelasController@show')->name('show.kelas');

     //route untuk detail_kelas
     Route::get('/kelas/detail_kelas/{id}', 'DetailKelasController@index')->name('detail_kelas');
     Route::get('/kelas/detail_kelas/create/{id}', 'DetailKelasController@create')->name('create.detail_kelas');
     Route::post('/kelas/detail_kelas/submit', 'DetailKelasController@submit')->name('submit.detail_kelas');
     Route::get('/kelas/delete/{id}/{id_kelas}', 'DetailKelasController@delete')->name('delete.detail_kelas');


    //route untuk amalan_yaumi
    Route::get('/amalan_yaumi', 'AmalanYaumiController@index')->name('amalan');
    Route::post('/amalan_yaumi', 'AmalanYaumiController@store')->name('store.amalan');
    Route::post('/amalan_yaumi_evaluasi', 'AmalanYaumiController@store_evaluasi')->name('store.evaluasi');

    //route untuk penilaian
    Route::get('/nilai', 'NilaiMentoringController@index')->name('nilai');
    Route::get('/nilai/create', 'NilaiMentoringController@create')->name('create.nilai');
    Route::post('/nilai/submit', 'NilaiMentoringController@submit')->name('submit.nilai');
    Route::get('/nilai/delete/{id}', 'NilaiMentoringController@delete')->name('delete.nilai');
    Route::get('/nilai/{id}/edit', 'NilaiMentoringController@edit')->name('edit.nilai');
    Route::post('/nilai/{id}', 'NilaiMentoringController@update')->name('update.nilai');
    Route::get('/nilai/{id}/show', 'NilaiMentoringController@show')->name('show.nilai');
    Route::get('/nilai/search', 'NilaiMentoringController@search')->name('search.nilai');
    Route::get('/nilai-cetak', 'NilaiMentoringController@nilai_cetak')->name('cetak.nilai');
    Route::post('/nilai-cetak', 'NilaiMentoringController@cetak')->name('cetak.nilai.store');
    Route::post('/api-mentee', 'NilaiMentoringController@api_mentee')->name('api_mentee.nilai');
    Route::post('/nilai-cetak/dropdown', 'NilaiMentoringController@dropdown')->name('dropdown.nilai');

    //route untuk periode
    Route::get('/periode', 'PeriodeController@index')->name('periode');
    Route::get('/periode/create', 'PeriodeController@create')->name('create.periode');
    Route::post('/periode/submit', 'PeriodeController@submit')->name('submit.periode');
    Route::get('/periode/{id}/edit', 'PeriodeController@edit')->name('edit.periode');
    Route::patch('/periode/{id}', 'PeriodeController@update')->name('update.periode');
    Route::get('/periode/delete/{id}', 'PeriodeController@delete')->name('delete.periode');

    //Route untuk laporan
    Route::get('/laporan', 'LaporanController@index')->name('laporan');
    Route::get('/laporan/create', 'LaporanController@create')->name('create.laporan');
    Route::post('/laporan/submit', 'LaporanController@submit')->name('submit.laporan');
    Route::get('/laporan/{id}/edit', 'LaporanController@edit')->name('edit.laporan');
    Route::patch('/laporan/{id}', 'LaporanController@update')->name('update.laporan');
    Route::get('/laporan/delete/{id}', 'LaporanController@delete')->name('delete.laporan');
    Route::get('/laporan/{id}/show', 'LaporanController@show')->name('show.laporan');
    Route::post('/laporan/create/dropdown', 'LaporanController@dropdown')->name('dropdown.laporan');

    //Route untuk SCM
    Route::get('/scm', 'SCMController@index')->name('scm');
    Route::get('/scm/create', 'SCMController@create')->name('create.scm');
    Route::post('/scm/submit', 'SCMController@submit')->name('submit.scm');
    Route::get('/scm/status/{id}', 'SCMController@status')->name('status.scm');
    Route::get('/scm-cetak', 'SCMController@scm_cetak')->name('cetak.scm');
    Route::post('/scm-cetak', 'SCMController@store')->name('cetak.scm.store');
    Route::get('/scm/{id}/show', 'SCMController@show')->name('show.scm');

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});
