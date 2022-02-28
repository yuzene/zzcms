<?php

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    use HasFactory;
    //定义表
    public $table = 'auth';
    //定义主键(如果主键名为id可以省略)
    public $primaryKey = 'id';
    //定义允许修改的值
    public $guarded = [];


}
