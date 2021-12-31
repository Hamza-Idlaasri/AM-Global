<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller\Auth\RegisterController;


// Login & Registration




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

/********** Login & Registration  ******************************************/

/** Login : **/
Route::get('/login',[App\Http\Controllers\Auth\Login::class,'index'])->name('login');
Route::get('/',[App\Http\Controllers\Auth\Login::class,'index']);
Route::post('/login',[App\Http\Controllers\Auth\Login::class,'store']);

/** Register : **/
Route::get('/register',[App\Http\Controllers\Auth\Register::class,'index'])->name('register');
Route::post('/register',[App\Http\Controllers\Auth\Register::class,'store']);

/** Logout : **/
Route::post('/logout',[App\Http\Controllers\Auth\Logout::class,'logout'])->name('logout');

// User Properties: 

Route::prefix('user')->group(function () {

    /** User Profile : **/
    Route::get('/profile', [App\Http\Controllers\Auth\UserProfile::class,'userProfile'])->name('userProfile');
    /** Delete his Account : **/
    // Route::delete('/{user}',[App\Http\Controllers\Auth\UserProfile::class,'deleteMyAccount'])->name('deleteMyAccount');
    
    
    /** Edit his Info : **/
    // Change Password
    Route::get('/edit-password', [App\Http\Controllers\Auth\UserProfile::class,'indexPass'])->name('edit-password');
    Route::put('/change-password',[App\Http\Controllers\Auth\UserProfile::class,'changePassword'])->name('changePassword');
    
    // Change Username/Email
    Route::get('/edit-info', [App\Http\Controllers\Auth\UserProfile::class,'indexInfo'])->name('edit-info');
    Route::put('/change-info',[App\Http\Controllers\Auth\UserProfile::class,'changeNameEmail'])->name('changeInfo');
    
});

/************************************************************************* */

/********** Overview *******************************************************/

Route::get('/overview', App\Http\Livewire\Overview::class)->name('overview');

/************************************************************************* */

/********** Monitoring *****************************************************/

Route::get('/monitoring/hosts', App\Http\Livewire\Monitoring\Hosts::class)->name('monitoring.hosts')->middleware('auth');
Route::get('/monitoring/boxs', App\Http\Livewire\Monitoring\Boxs::class)->name('monitoring.boxs')->middleware('auth');
Route::get('/monitoring/services', App\Http\Livewire\Monitoring\Services::class)->name('monitoring.services')->middleware('auth');
Route::get('/monitoring/equipements', App\Http\Livewire\Monitoring\Equips::class)->name('monitoring.equips')->middleware('auth');

/************************************************************************* */

/********** Problems *****************************************************/

Route::get('/problems/hosts', App\Http\Livewire\Problems\Hosts::class)->name('problems.hosts')->middleware('auth');
Route::get('/problems/boxs', App\Http\Livewire\Problems\Boxs::class)->name('problems.boxs')->middleware('auth');
Route::get('/problems/services', App\Http\Livewire\Problems\Services::class)->name('problems.services')->middleware('auth');
Route::get('/problems/equipements', App\Http\Livewire\Problems\Equips::class)->name('problems.equips')->middleware('auth');

/************************************************************************* */

/********** Historic *******************************************************/

Route::prefix('historiques')->group(function () {

    Route::get('/hosts', App\Http\Livewire\Historic\Hosts::class)->name('historic.hosts')->middleware('auth');
    Route::get('/boxs', App\Http\Livewire\Historic\Boxs::class)->name('historic.boxs')->middleware('auth');
    Route::get('/services', App\Http\Livewire\Historic\Services::class)->name('historic.services')->middleware('auth');
    Route::get('/equipements', App\Http\Livewire\Historic\Equips::class)->name('historic.equips')->middleware('auth');

    // Download PDF / CVS :
    /** PDF */
    Route::get('/hosts/download-PDF/{name}/{status}/{from}/{to}',[App\Http\Controllers\Download\Hosts::class,'download'])->name('hosts.pdf')->middleware('auth');
    Route::get('/boxs/download-PDF/{name}/{status}/{from}/{to}',[App\Http\Controllers\Download\Boxs::class,'download'])->name('boxs.pdf')->middleware('auth');
    Route::get('/services/download-PDF/{name}/{status}/{from}/{to}',[App\Http\Controllers\Download\Services::class,'download'])->name('services.pdf')->middleware('auth');
    Route::get('/equipements/download-PDF/{name}/{status}/{from}/{to}',[App\Http\Controllers\Download\Equips::class,'download'])->name('equips.pdf')->middleware('auth');
    /** CSV */
    Route::get('/hosts/CSV',[App\Http\Controllers\Download\Hosts::class,'csv'])->name('hosts.csv')->middleware('auth');
    Route::get('/boxs/CSV',[App\Http\Controllers\Download\Boxs::class,'csv'])->name('boxs.csv')->middleware('auth');
    Route::get('/services/CSV',[App\Http\Controllers\Download\Services::class,'csv'])->name('services.csv')->middleware('auth');
    Route::get('/equipements/CSV',[App\Http\Controllers\Download\Equips::class,'csv'])->name('equips.csv')->middleware('auth');

});
    
/************************************************************************* */



/********** Statistic *******************************************************/

Route::get('/statistiques/hosts', App\Http\Livewire\Statistic\Hosts::class)->name('statistic.hosts')->middleware('auth');
Route::get('/statistiques/boxs', App\Http\Livewire\Statistic\Boxs::class)->name('statistic.boxs')->middleware('auth');
Route::get('/statistiques/services', App\Http\Livewire\Statistic\Services::class)->name('statistic.services')->middleware('auth');
Route::get('/statistiques/equipements', App\Http\Livewire\Statistic\Equips::class)->name('statistic.equips')->middleware('auth');

/************************************************************************* */

/********** Notification ***************************************************/

Route::get('/notifications', App\Http\Livewire\Notifications::class)->middleware('auth');

/************************************************************************* */

/********** Carte **********************************************************/

Route::get('/carte/automap', App\Http\Livewire\Carte\Automap::class)->middleware('auth');

/************************************************************************* */

/********** Sites **********************************************************/

Route::get('/sites', [App\Http\Controllers\Site\AddNewSite::class,'sites']);
Route::get('/add-site', [App\Http\Controllers\Site\AddNewSite::class,'newSite']);
Route::post('/add-site', [App\Http\Controllers\Site\AddNewSite::class,'addSite'])->name('addSite');
Route::get('/switch-db/{db_host}/{db_port}/{db_database}/{db_username}/{db_password}', [App\Http\Controllers\Site\SwitchDB::class,'switchDB'])->name('switchDB');

/************************************************************************* */