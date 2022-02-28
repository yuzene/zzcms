<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//工具类
class ToolController extends Controller
{
    //把给定字符串的字符集全部转化为utf-8
    public static function charset($content)
    {
        preg_match('#<meta.*charset=([a-z\d]*)#i', $content, $charset);
//        $contents = iconv($charset[1], 'utf-8', $content);
        $contents = mb_convert_encoding($content, 'utf-8', $charset[1]);

        return $contents;
    }
}
