<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//sử dụng mô hình MVC
//load class Model để sử dụng ở đây
use App\Models\News;
// sử dụng mô hình MVC: Lấy dữ liệu từ model

class NewsController extends Controller
{
    //tạo biến $modle (là biến trong class NewsController)
    public $model;
    //hàm tạo
    public function __construct(){
    	//gán biến $model trở thành object của class News
    	$this->model = new News();// khi đó từ biến model có thể truy cập được vào các hàm, biến của class News từ đây
    	
    }
    //lấy danh sách bản ghi
    public function read(){
    		//lấy dữ liệu từ hàm modelRead của class news
    		$data = $this->model->modelRead();
    		//gọi view, truyền dữ liệu ra view
    		return view("backend.NewsRead",["data"=>$data]);
    }
    //update
    public function update($id){
    	//lấy dữ liệu từ model
    	$record = $this->model->modelGetRecord($id);
    	return view("backend.NewsCreateUpdate",["record"=>$record]);
    }
    //update Post
    public function updatePost($id){
    	$this->model->modelUpdate($id);
    	return redirect(url('admin/news'));
    }
    //create
    public function create(){
    	return view("backend.NewsCreateUpdate");
    }
    //create Post
    public function createPost(){
    	$this->model->modelCreate();
    	return redirect(url('admin/news'));
    }
    //delete
    public function delete($id){
    	$this->model->modelDelete($id);
    	return redirect(url('admin/news'));
    }
}
