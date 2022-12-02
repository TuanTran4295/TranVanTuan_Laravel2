<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Trong controller muốn sử dụng đối tượng nào thì phải khai báo đối tượng đó
use View; //hiển thị view
use DB; //đối tượng thao tác csdl

//sử dụng Eloquent để truy vấn csdl -> sử dụng model thay cho DB như ở UsersController
//muốn sử dụng model Categories thì phải khai báo ở đây => sử dụng Eloquent
use App\Models\Categories;

class CategoriesController extends Controller
{
    //url: public/admin/categories
    public function read(){
    	$data = Categories::orderBy("id","desc")->paginate(4);
    	return View::make("backend.CategoriesRead",["data"=>$data]);
    	//có thể sử dụng: return view("backend.CategoriesRead",["data"=>$data]);
    }
    //update Get
    public function update($id){
    	$record = Categories::where("id","=",$id)->first();
    	return view("backend.CategoriesCreateUpdate",["record"=>$record]);
    }
    //UPDATE Post
    public function updatePost($id){
    	$name = request("name");
    	//update name
    	Categories::where("id","=",$id)->update(["name"=>$name]);
    	//di chuyển đến 1 url khác
    	return redirect(url("admin/categories"));
    }
    //create Get
    public function create(){
    	return view("backend.CategoriesCreateUpdate");
    }
    //create Post
    public function createPost(){
    	$name = request("name");
    	//update name
    	Categories::insert(["name"=>$name]);
    	//di chuyển đến 1 url khác
    	return redirect(url("admin/categories"));
    }
    //delete
    public function delete($id){
    	//lấy 1 bản ghi
    	Categories::where("id","=",$id)->delete();
    	//di chuyển đến 1 url khác
    	return redirect(url("admin/categories"));
    }
}
