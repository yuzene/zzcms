<?php

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Article extends Model
{
    use HasFactory;
    //定义表
    public $table = 'article';
    //定义主键(如果主键名为id可以省略)
    public $primaryKey = 'id';
    //定义允许修改的值
    public $guarded = [];
    //分类模型关联
    public function sort(){
        return $this->belongsTo(\App\Models\Model\Sort::class,  'article_sort');
    }
    //分类访问器
    public function getArticleSortNameAttribute()
    {
        return $this->sort->sortname;
    }

    //作者模型关联
    public function auth(){
        return $this->belongsTo(Auth::class, 'article_auth');
    }
    //作者访问器
    public function getArticleAuthNameAttribute()
    {
        return $this->auth->authname;
    }
    //源站模型关联
    public function site(){
        return $this->belongsTo(Site::class, 'sourceid');
    }
    //源站访问器
    public function getSourceNameAttribute($key)
    {
        return $this->site->sitename;
    }
}
