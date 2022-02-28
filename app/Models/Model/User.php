<?php

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    //定义表
    public $table = 'user';
    //定义主键(如果主键名为id可以省略)
    public $primaryKey = 'id';
    //定义允许修改的值
    public $guarded = [];


}
