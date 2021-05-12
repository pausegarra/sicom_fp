<?php

use Aacotroneo\Saml2\Saml2Auth;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Mail\CustomerCreated;
use Illuminate\Support\Facades\Mail;

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
/**
 * LOGIN ROUTES
 */
Route::get('login', [
  'as' => 'login',
  'uses' => 'Auth\LoginController@showLoginForm'
]);
Route::post('login', [
  'as' => '',
  'uses' => 'Auth\LoginController@authenticate'
]);
Route::post('logout', [
  'as' => 'logout',
  'uses' => 'Auth\LoginController@logout'
]);
Route::any('error',function(){
  return abort(500, 'Server Error');
})->name('error');
Route::any('bye',function(){
  return 'Bye';}
)->name('bye');
 /**
  * END LOGIN ROUTES
  */

Route::redirect('/','/login');
Route::group(['middleware' => 'auth'],function() {
  Route::get('/home', 'HomeController@index')->name('home');
  Route::view('/clientes','customer')->name('customer');
  Route::get('/clientes/{id}','CustomerController@show')->name('customer.show');
  Route::view('/crear-pedido','create-order')->name('order.create');

  Route::view('/clientes-potenciales','potential-customer')->name('customer.potential');
  Route::view('/clientes-potenciales/crear','potential-customer-create')->name('customer.potential.create');
  Route::get('/clientes-potenciales/{id}','CustomerController@showPotential')->name('potential.customer.show');

  Route::get('/pedido/{order}','CustomerController@showOrder')->name('customer.order.show');
  Route::view('/pedidos','orders')->name('orders');
});
// Route::any('test',function(){return 'YOU ARE AT HOME';})->name('test');
// Route::any('error',function(){return 'ERROR !!';});
// Route::any('bye',function(){return 'Bye Bye Bye -- !!!!!';})->name('bye');