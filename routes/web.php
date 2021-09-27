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

//route untuk dashboard
Route::get('/', 'DashboardController@index')->name('dashboard');

//route untuk mentor
Route::get('/mentor', 'MentorController@index')->name('mentor');
Route::get('/mentor/create', 'MentorController@create')->name('create.mentor');
Route::post('/mentor/submit', 'MentorController@submit')->name('submit.mentor');
Route::delete('/mentor/delete/{id}', 'MentorController@delete')->name('delete.mentor');
Route::get('/mentor/{id}/edit', 'MentorController@edit')->name('edit.mentor');
Route::patch('/mentor/{id}', 'MentorController@update')->name('update.mentor');

//route untuk mentee
Route::get('/mentee', 'MenteeController@index')->name('mentee');
Route::get('/mentee/create', 'MenteeController@create')->name('create.mentee');
Route::post('/mentee/submit', 'MenteeController@submit')->name('submit.mentee');
Route::get('/mentee/{id}/edit', 'MenteeController@edit')->name('edit.mentee');
Route::patch('/mentee/{id}', 'MenteeController@update')->name('update.mentee');

//route untuk dosen
Route::get('/dosen', 'DosenController@index')->name('dosen');
Route::get('/dosen/create', 'DosenController@create')->name('create.dosen');
Route::post('/dosen/submit', 'DosenController@submit')->name('submit.dosen');
Route::get('/dosen/{id}/edit', 'DosenController@edit')->name('edit.dosen');
Route::patch('/dosen/{id}', 'DosenController@update')->name('update.dosen');

//route untuk kelompok
Route::get('/kelompok', 'KelompokController@index')->name('kelompok');
Route::get('/kelompok/create', 'KelompokController@create')->name('create.kelompok');
Route::post('/kelompok/submit', 'KelompokController@submit')->name('submit.kelompok');
Route::get('/kelompok/{id}/edit', 'KelompokController@edit')->name('edit.kelompok');
Route::patch('/kelompok/{id}', 'KelompokController@update')->name('update.kelompok');

//route untuk kelas
Route::get('/kelas', 'KelasController@index')->name('kelas');
Route::get('/kelas/create', 'KelasController@create')->name('create.kelas');
Route::post('/kelas/submit', 'KelasController@submit')->name('submit.kelas');
Route::get('/kelas/{id}/edit', 'KelasController@edit')->name('edit.kelas');
Route::patch('/kelas/{id}', 'KelasController@update')->name('update.kelas');

//route untuk amalan_yaumi
Route::get('/amalan_yaumi', 'AmalanYaumiController@index')->name('amalan');

//route untuk materi
Route::get('/materi', 'PeriodeController@index')->name('materi');

//route untuk penilaian
Route::get('/penilaian', 'PenilaianMentoringController@index')->name('penilaian');