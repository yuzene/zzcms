<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Redirect;
use App\Models\Model\User;

class RoleAdmin
{
    /**
     * Handle an incoming request.
     *验证用户是否为管理员
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user_id = $request->session()->get('user_id');
        $user = User::where('id',$user_id)->first();
        if (!$user->role){
            return redirect('login')->with('error','非管理员');
        };
        return $next($request);
    }
}
