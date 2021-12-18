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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user/list', 'EditShowPegawai@index')->name('user.listuser');
Route::put('/user/{user}', 'EditShowPegawai@update')->name('user.update');
Route::get('user/{user}/edit', 'EditShowPegawai@edit')->name('user.edit');
Route::post('/deleteUser', 'EditShowPegawai@delete');
Route::get('/showUser', 'EditShowPegawai@showUpdate');


Route::resource('jabatan', 'JabatanController');
//notadinas
Route::get('notadinas/terkirim/{id}', 'NotaDinasController@sent')->name('notadinas.sent');
Route::resource('notadinas', 'NotaDinasController');
//harus ditambahain yang disJabatan
Route::post('/disJabatan/{id}', 'NotaDinasController@disJabatan');
//untuk ajax di app.blade
Route::post('/deleteNotdin', 'NotaDinasController@delete');
Route::get('/showNotdin', 'NotaDinasController@showUpdate');

//suratmasuk
Route::resource('suratmasuk', 'SuratMasukController');
Route::post('/deleteSurmas', 'SuratMasukController@delete');
Route::get('/showSurmas', 'SuratMasukController@showUpdate');

//suratkeluar
Route::resource('suratkeluar', 'SuratKeluarController');
Route::post('/deleteSurkel', 'SuratKeluarController@delete');
Route::get('/showSurkel', 'SuratKeluarController@showUpdate');

//disposisi
// Route::get('/showDisposisi', 'DisposisiController@showUpdate');
Route::resource('disposisi', 'DisposisiController');
Route::get('/disposisi/create/surmas={id}', 'DisposisiController@buatDispos')->name('disposisi.buat');
Route::post('/deleteDisposisi', 'DisposisiController@delete');
Route::get('/showDisposisi', 'DisposisiController@showUpdate');

//inbox
Route::get('/inbox', 'InboxController@index')->name('inbox.index');
Route::get('/inbox/inboxSurmas/{id}', 'InboxController@openSurmas')->name('inbox.openSurmas');
Route::get('/inbox/inboxSurkel/{id}', 'InboxController@openSurkel')->name('inbox.openSurkel');
Route::get('/inbox/inboxNotdin/{id}', 'InboxController@openNotdin')->name('inbox.openNotdin');
Route::get('/inbox/inboxDispos/{id}', 'InboxController@openDisposisi')->name('inbox.openDisposisi');
//untuk mengubah status jika button ditekan
Route::get('/inbox/inboxSurmas/Acc{id}', 'InboxController@approveSurmas')->name('inbox.accSurmas');
Route::put('/inbox/inboxSurkel/Acc{id}', 'InboxController@approveSurkel')->name('inbox.accSurkel');
Route::put('/inbox/inboxNotdin/Acc{id}', 'InboxController@approveNotdin')->name('inbox.accNotdin');
Route::put('/inbox/inboxDispos/Acc{id}', 'InboxController@approveDisposisi')->name('inbox.accDispos');
Route::put('/inbox/inboxSurkel/Rej{id}', 'InboxController@rejectSurkel')->name('inbox.rejSurkel');
Route::put('/inbox/inboxNotdin/Rej{id}', 'InboxController@rejectNotdin')->name('inbox.rejNotdin');
Route::put('/inbox/inboxDispos/Fwd{id}', 'InboxController@fwdDisposisi')->name('inbox.fwdDispos');
