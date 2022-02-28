<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;

//验证码类
class CodeController extends Controller
{
    public function captcha()
    {
        $builder = new CaptchaBuilder();
        $builder->build(150, 50);
        $phrase = $builder->getPhrase();
        //把内容闪存session(使用的是Session::flash(变量名,变量值))
        Session::flash('milkcaptcha', $phrase); //存储验证码
        ob_clean();
        //返回一个相应，携带验证码
        return response($builder->output())->header('Content-type', 'image/jpeg');
    }
}

