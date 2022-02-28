<?php

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sort extends Model
{
    use HasFactory;
    //定义表
    public $table = 'sort';
    //定义主键(如果主键名为id可以省略)
    public $primaryKey = 'id';
    //定义允许修改的值
    public $guarded = [];

    //分类查询构造器
    public function list(){
        $sorts = Sort::where('sortdel', 1)->get();
        return Sort::getTree($sorts);
    }
    //分类格式化
    public function getTree($sorts){
        //定义一个空数组
        $arr = [];
        //遍历所有分类
        foreach ($sorts as $v){
            //获取所有一级分类
            if(!$v->cid){
                $v->sortname = '├─'.$v->sortname;
                $arr[] = $v;

                //遍历一级分类下的二级分类
                foreach ($sorts as $n){
                    if($v->id == $n->cid){
                        $n->sortname = '│ 　├─'.$n->sortname;
                        $arr[] = $n;
                    }
                }
            }
        }
        return $arr;
    }
}
