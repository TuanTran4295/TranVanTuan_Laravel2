<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Categories extends Model
{
    use HasFactory;
    //khai báo tên table để sử dụng
    //chú ý: laravel quy điịnh bắt buộc phải sử dụng từ khóa protected, không được sử dụng public hoặc private
    protected $table = "categories";
    //nếu trong table categories không có 2 cột create_at và update_at thì phải khai báo dòng code bên dưới
    public $timestamps = false; //có nghĩa là sẽ không tự động fill thời gian vào cột create_at và update_at ( có nghĩa không cần tạo 2 cột này trong table categories)
}
