<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//trong controller muốn sử dụng đối tượng nào thì phải khai báo đối tượng đó ở đây
use View; //hiển thị view
//đối tượng thao tác csdl => sử dụng Query builder 
use DB;
//đối tượng mã hóa password
use Hash;
class UsersController extends Controller
{
    //url: public/admin/users
    public function read(){
    	/* 
    	truy vấn dữ liệu
    	DB::table("users") <=> Tác động vào bảng users
    	orderBy("id","desc") <=> order by id idesc 
    	paginate(4) <=> phân 4 bản ghi trên 1 trang
    	*/
    	$data = DB::table("users")->orderBy("id","desc")->paginate(4);
    	return View::make("backend.UsersRead",["data"=>$data]);
    }
    //update -GET
    public function update($id){
    	//first() <=> lấy 1 bản ghi
    	//lấy 1 bản ghi
    	$record = DB::table("users")->where("id","=",$id)->first();
    	return View::make("backend.UsersCreateUpdate",["record"=>$record]);
    }
    //update -POST
    public function updatePost($id){
    	$name = request("name"); // Request::get("name")
    	$email = request("email");//Request::get("email")
    	$password = request("password"); // Request::get("password")
    	//update name
    	DB::table("users")->where("id","=",$id)->update(["name"=>$name]);
    	//update email
    	DB::table("users")->where("id","=",$id)->update(["email"=>$email]);
    	//Nếu password không rỗng thì update password
    	if($password != ""){
    		//mã hóa password
    		$password = Hash::make($password);
    		DB::table("users")->where("id","=",$id)->update(["password"=>$password]);
    	}
    	//di chuyển đến 1 url khác
    	return redirect(url("admin/users"));
    }
    //create -GET
    public function create(){
    	//first() <=> lấy 1 bản ghi
    	return View::make("backend.UsersCreateUpdate");
    }
    //create -POST
    public function createPost(){
    	$name = request("name"); // Request::get("name")
    	$email = request("email"); // Request::get("email")
    	$password = request("password"); // Request::get("password")
		//mã hóa password
		$password = Hash::make($password);
		//kiểm tra xem email đã tồn tại chưa , nếu chưa tồn tại thì mới cho insert
		$countEmail = DB::table("users")->where("email","=",$email)->Count();
		if($countEmail == 0){
			//insert bản ghi
			DB::table("users")->insert(["name"=>$name,"email"=>$email,"password"=>$password]);
			//di chuyển đến 1 url khác
			return redirect(url("admin/users"));
		}else{
			//di chuyển đến 1 url khác
    	return redirect(url("admin/users?notify=emailExists"));
		}
    }
    //delete
    public function delete($id) {
    	//lấy 1 bản ghi
    	DB::table("users")->where("id","=",$id)->delete();
    	//di chuyển đến 1 url khác
    	return redirect(url("admin/users")); 
    }
}
