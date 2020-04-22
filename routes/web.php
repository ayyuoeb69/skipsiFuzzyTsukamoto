<?php

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

Route::get('/', [
    'uses' => 'Utama\UtamaController@index'
])->name('/');
Route::post('logout', [
    'as' => 'logout',
    'uses' => 'Auth\LoginController@logout'
  ]);
Route::post('login', [
    'as' => '',
    'uses' => 'Auth\LoginController@login'
  ])->name('login');
  Route::post('logout', [
    'as' => 'logout',
    'uses' => 'Auth\LoginController@logout'
  ]);
  Route::get('/login', [
    'uses' => 'AdminUtama\LoginController@showLoginForm'
  ])->name('admin');
  Route::post('/titik/sungai/{id}', 'Relawan\InputController@dasar_sungai');
  Route::post('/titik/verif/{id}', 'AdminSungai\PetaController@verif_titik');
Route::group(['middleware' => 'admin_utama'], function () {
	Route::get('/admin_utama/beranda', 'AdminUtama\BerandaController@index')->name('admin_utama_beranda');
	Route::get('/admin_utama/variable', 'AdminUtama\VariabelController@index')->name('admin_utama_variable');
	Route::post('/admin_utama/variable/add', 'AdminUtama\VariabelController@store')->name('admin_utama_add_variable');
	Route::delete('/admin_utama/variable/delete/{id}', 'AdminUtama\VariabelController@destroy')->name('admin_utama_delete_variable');
	Route::get('/admin_utama/himpunan/{id}', 'AdminUtama\HimpunanController@index')->name('admin_utama_himpunan');
	Route::get('/admin_utama/himpunan/settings/{id}', 'AdminUtama\HimpunanController@settings')->name('admin_utama_himpunan_setting');
	Route::post('/admin_utama/himpunan/add/{id}', 'AdminUtama\HimpunanController@store')->name('admin_utama_add_himpunan');
	Route::get('/admin_utama/aturan', 'AdminUtama\AturanController@index')->name('admin_utama_aturan');
	Route::post('/admin_utama/aturan/add', 'AdminUtama\AturanController@store')->name('admin_utama_add_aturan');
	Route::get('/admin_utama/aturan/add', 'AdminUtama\AturanController@add')->name('admin_utama_add_aturan');
	Route::delete('/admin_utama/aturan/delete/{id}', 'AdminUtama\AturanController@destroy')->name('admin_utama_delete_aturan');
	Route::get('/admin_utama/sungai', 'AdminUtama\SungaiController@index')->name('admin_utama_sungai');
	Route::post('/admin_utama/sungai/add', 'AdminUtama\SungaiController@store')->name('admin_utama_add_sungai');
	Route::post('/admin_utama/sungai/admin/add', 'AdminUtama\SungaiController@store_admin')->name('admin_utama_add_admin_sungai');
	Route::delete('/admin_utama/admin/delete/{id}', 'AdminUtama\SungaiController@destroy_admin')->name('admin_utama_delete_admin');
	Route::delete('/admin_utama/sungai/delete/{id}', 'AdminUtama\SungaiController@destroy')->name('admin_utama_delete_sungai');
});
Route::group(['middleware' => 'relawan'], function () {
	Route::get('/relawan/beranda', 'Relawan\BerandaController@index')->name('relawan_beranda');
	Route::get('/relawan/input', 'Relawan\InputController@index')->name('relawan_input');
	Route::post('/relawan/input/add', 'Relawan\InputController@store')->name('relawan_add_data');
	Route::get('/relawan/riwayat', 'Relawan\RiwayatController@index')->name('relawan_riwayat');
	Route::delete('/relawan/riwayat/delete/{id}', 'Relawan\RiwayatController@destroy')->name('delete_relawan_riwayat');
});
Route::group(['middleware' => 'admin_sungai'], function () {
	Route::get('/admin_sungai/beranda', 'AdminSungai\BerandaController@index')->name('admin_sungai_beranda');
	Route::get('/admin_sungai/peta', 'AdminSungai\PetaController@index')->name('admin_sungai_peta');
	Route::get('/admin_sungai/users', 'AdminSungai\RelawanController@index')->name('admin_sungai_users');
	Route::put('/admin_sungai/setuju/{id}', 'AdminSungai\PetaController@setuju')->name('admin_sungai_setuju');
	Route::put('/admin_sungai/tolak/{id}', 'AdminSungai\PetaController@tolak')->name('admin_sungai_tolak');
});