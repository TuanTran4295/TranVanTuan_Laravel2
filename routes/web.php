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
//-------
//url: public/login
Route::get('login',function(){
	return View::make('backend.Login');
	/*
	laravel gọi view thông qua 2 cách
	cách 1: return View::make('tenview')
	cách 1: return view('tenview')
	*/
});
//sau khi ấn nút submit
Route::post('login',function(){
	//lấy giá trị form
	$email = request("email");// <=> $email = Request::get("email");
	$password = request("password");// <=> $password = Request::get("password");
	if(Auth::Attempt(["email"=>$email,"password"=>$password]))
		return redirect(url("admin/users"));
	else
		return redirect(url("login?notify=invalid"));
});
//url: public/logout
Route::get('logout',function(){
	Auth::logout();//Auth là đối tượng có sẵn của laravel
	return redirect(url("login"));
});
//-------
//admin 
//url: public/admin
Route::get('admin', function () {
	//redirect -> di chuyển đến 1 url
	//url -> tạo đường dẫn url
    return redirect(url('admin/users'));
});
//----------
//khai bao class controller o day
use App\Http\Controllers\UsersController;
//url: public/admin/users -> hien thi danh sach cac ban ghi
Route::get("admin/users",[UsersController::class,"read"])->middleware("check_login");
//url: public/admin/users/update/id -> sua ban ghi - GET
Route::get("admin/users/update/{id}",[UsersController::class,"update"])->middleware("check_login");
//url: public/admin/users/update/id -> sua ban ghi - POST
Route::post("admin/users/update/{id}",[UsersController::class,"updatePost"])->middleware("check_login");
//url: public/admin/users/create -> tao moi ban ghi - GET
Route::get("admin/users/create",[UsersController::class,"create"])->middleware("check_login");
//url: public/admin/users/create -> sua ban ghi - POST
Route::post("admin/users/create",[UsersController::class,"createPost"])->middleware("check_login");
//url: public/admin/users/delete/id -> sua ban ghi - GET
Route::get("admin/users/delete/{id}",[UsersController::class,"delete"])->middleware("check_login");
//----------

//----------
//khai bao class controller o day
use App\Http\Controllers\CategoriesController;
//url: public/admin/categories -> hien thi danh sach cac ban ghi
Route::get("admin/categories",[CategoriesController::class,"read"]);//->middleware("check_login");
//url: public/admin/categories/update/id -> sua ban ghi - GET
Route::get("admin/categories/update/{id}",[CategoriesController::class,"update"]);//->middleware("check_login");
//url: public/admin/categories/update/id -> sua ban ghi - POST
Route::post("admin/categories/update/{id}",[CategoriesController::class,"updatePost"]);//->middleware("check_login");
//url: public/admin/categories/create -> tao moi ban ghi - GET
Route::get("admin/categories/create",[CategoriesController::class,"create"]);//->middleware("check_login");
//url: public/admin/categories/create -> sua ban ghi - POST
Route::post("admin/categories/create",[CategoriesController::class,"createPost"]);//->middleware("check_login");
//url: public/admin/categories/delete/id -> sua ban ghi - GET
Route::get("admin/categories/delete/{id}",[CategoriesController::class,"delete"]);//->middleware("check_login");
//----------

//----------
//khai bao class controller o day
use App\Http\Controllers\NewsController;
//url: public/admin/news -> hien thi danh sach cac ban ghi
Route::get("admin/news",[NewsController::class,"read"]);//->middleware("check_login");
//url: public/admin/news/update/id -> sua ban ghi - GET
Route::get("admin/news/update/{id}",[NewsController::class,"update"]);//->middleware("check_login");
//url: public/admin/news/update/id -> sua ban ghi - POST
Route::post("admin/news/update/{id}",[NewsController::class,"updatePost"]);//->middleware("check_login");
//url: public/admin/news/create -> tao moi ban ghi - GET
Route::get("admin/news/create",[NewsController::class,"create"]);//->middleware("check_login");
//url: public/admin/news/create -> sua ban ghi - POST
Route::post("admin/news/create",[NewsController::class,"createPost"]);//->middleware("check_login");
//url: public/admin/news/delete/id -> sua ban ghi - GET
Route::get("admin/news/delete/{id}",[NewsController::class,"delete"]);//->middleware("check_login");
//----------

//frontend
Route::get('/', function () {
	echo Hash::make("123");// mã hóa chuỗi 123 thành các ký tự mã hóa <=> md5
    return view('welcome');
});
