<?php

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;
    //定义表
    public $table = 'site';
    //定义主键(如果主键名为id可以省略)
    public $primaryKey = 'id';
    //定义允许修改的值
    public $guarded = [];
    //文章模型关联
    public function article(){
        return $this->hasMany(Article::class, 'sourceid' , 'id');
    }
    public function getTotalAttribute()
    {
        return $this->article()->count();
    }
}
