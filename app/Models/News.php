<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//trong Model, Controller muốn sử dụng đối tượng nào thì phải khai báo đối tượng đó
//sử dụng đối tượng DB để thao tác csdl
use DB;
// đối tượng để lấy theo kiểu $_GET, $_POST, $_FILES
use Request;

class News extends Model
{
    use HasFactory;
    //lấy các bản ghi có phân trang
    public function modelRead(){
    	$data = DB::table("news")->orderBy("id","desc")->paginate(4);
    	return $data;
    }
    //lấy 1 bản ghi
    public function modelGetRecord($id){
    	$record = DB::table("news")->where("id","=",$id)->first();
    	return $record;
    }
    //update
    public function modelUpdate($id){
    	$name = request("name"); // <=> Request::get("name");
    	$category_id = request("category_id");
    	$description = request("description");
    	$content = request("content");
    	$hot = request("hot") != "" ? 1 : 0;
    	//update bản ghi
    	DB::table("news")->where("id","=",$id)->update(["name"=>$name, "category_id"=>$category_id, "description"=>$description, "content"=>$content, "hot"=>$hot]);
    	//nếu có ảnh thì update ảnh
    	if(Request::hasFile("photo")){
    		//---
    		//lấy ảnh củ để xóa
    		//select("photo") lấy cột photo
    		$oldPhoto = DB::table("news")->where("id","=",$id)->select("photo")->first();
    		if(isset($oldPhoto->photo) && file_exists("upload/news/".$oldPhoto->photo))
    			unlink("upload/news/".$oldPhoto->photo);
    		//---
    		//Request::file("photo")->getClientOriginalName() lấy tên file
    		$photo = time()."_".Request::file("photo")->getClientOriginalName();
    		//thực hiện load ảnh
    		Request::file("photo")->move("upload/news",$photo);
    		//uploaf bản ghi
    		DB::table("news")->where("id","=",$id)->update(["photo"=>$photo]);
    	}
    }
    //create
    public function modelCreate(){
        $name = request("name"); //<=> Request::get("name");
        $category_id = request("category_id");
        $description = request("description");
        $content = request("content");
        $hot = request("hot") != "" ? 1 : 0;
        $photo = "";
        //neu co anh thi update anh
        if(Request::hasFile("photo")){
            //Request::file("photo")->getClientOriginalName() lay ten file
            $photo = time()."_".Request::file("photo")->getClientOriginalName();
            //thuc hien upload anh
            Request::file("photo")->move("upload/news",$photo);
        }
        //create ban ghi
        DB::table("news")->insert(["name"=>$name,"category_id"=>$category_id,"description"=>$description,"content"=>$content,"hot"=>$hot,"photo"=>$photo]);        
    }
    //delete
    public function modelDelete($id){
    	//lấy ảnh củ để xóa
		//select("photo") lấy cột photo
		$oldPhoto = DB::table("news")->where("id","=",$id)->select("photo")->first();
		if(isset($oldPhoto->photo) && file_exists("upload/news/".$oldPhoto->photo))
			unlink("upload/news/".$oldPhoto->photo);
		//---
		DB::table("news")->where("id","=",$id)->delete();
    }

}
