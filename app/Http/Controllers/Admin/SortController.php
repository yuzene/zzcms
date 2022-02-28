<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Model\Sort;
use Illuminate\Http\Request;

class SortController extends Controller
{
    //分类列表
    public function index()
    {
        $sorts = Sort::list();
        $count = count($sorts);
        return view('admin.sort.index', compact('sorts','count'));
    }

    //返回分类视图
    public function create()
    {
        $sorts = Sort::where('cid', 0)->get();
        return view('admin.sort.add', compact('sorts'));
    }

    //添加分类处理
    public function deal(Request $request)
    {
        $input = $request->all();
        $validated = $request->validate([
            'sortname' => 'required|max:255',
            'key' => 'required',
        ]);
        $sorta = Sort::where('sortname', $input['sortname'])->value('id');
        $sortb = Sort::where('key', $input['key'])->value('id');
        if ($sorta) {
            $data = [
                'status' => 0,
                'message' => '分类名已存在'
            ];
        } elseif ($sortb) {
            $data = [
                'status' => 0,
                'message' => 'KEY已存在'
            ];
        } else {
            $res = Sort::create(['sortname' => $input['sortname'], 'key' => $input['key'], 'cid' => $input['cid']]);
            if ($res) {
                $data = [
                    'status' => 1,
                    'message' => '添加成功'
                ];
            } else {
                $data = [
                    'status' => 0,
                    'message' => '添加失败'
                ];
            }
        }
        return $data;
    }

    //返回编辑分类视图
    public function edit($id)
    {
        $sort = Sort::find($id);
        $sorts = Sort::where('cid', 0)->get();
        return view('admin.sort.edit', compact('sort', 'sorts'));
    }

    //修改分类处理
    public function editDeal(Request $request)
    {
        $input = $request->all();
        $validated = $request->validate([
            'sortname' => 'required|max:255',
            'key' => 'required',
        ]);
        $sortname = Sort::where('id', '!=', $input['id'])
            ->where(function ($query) use ($input) {
                $query->where('sortname', $input['sortname'])
                    ->orWhere('key', $input['key']);
            })->value('sortname');
        if ($sortname) {
            if ($sortname == $input['sortname']) {
                $data = [
                    'status' => 0,
                    'message' => '分类名已存在'
                ];
            } else {
                $data = [
                    'status' => 0,
                    'message' => 'KEY已存在'
                ];
            }
            return $data;
        }
        $sort = Sort::find($input['id']);
        $sort->cid = $input['cid'];
        $sort->sortname = $input['sortname'];
        $sort->key = $input['key'];
        $res = $sort->save();
        if ($res) {
            $data = [
                'status' => 1,
                'message' => '修改成功'
            ];
        } else {
            $data = [
                'status' => 0,
                'message' => '修改失败'
            ];
        }

        return $data;

    }
    //删除分类
    public function delete($id){
        $sort = Sort::find($id);
        $sort->sortdel = 0;
        $res = $sort->save();
        if ($res) {
            $data = [
                'status' => 1,
                'message' => '删除成功'
            ];
        } else {
            $data = [
                'status' => 0,
                'message' => '删除失败'
            ];
        }

        return $data;
    }

    //批量删除分类
    public function delAll(Request $request){
        $ids = $request->input('ids');
        foreach ($ids as $v){
            $sort = Sort::find($v);
            $sort->sortdel = 0;
            $sort->save();
        }
        return $data = [
            'status' => 1,
            'message' => '删除成功'
        ];


    }
}
