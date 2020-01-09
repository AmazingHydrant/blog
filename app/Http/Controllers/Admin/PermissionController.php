<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //權限頁面
        $perm = Permission::paginate(10);
        return view('admin.permission.list', compact('perm'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //新增頁面
        return view('admin.permission.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 新增角色

        $perm_name = $request->get('perm_name');
        $perm_url = $request->get('perm_url');
        $res = Permission::create(['perm_name' => $perm_name, 'perm_url' => $perm_url]);
        if ($res) {
            $data = [
                'status' => 1,
                'message' => '新增權限成功',
            ];
        } else {
            $data = [
                'status' => 0,
                'message' => '新增權限失敗',
            ];
        }
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //編輯角色
        $perm = Permission::find($id);
        return view('admin.permission.edit', compact('perm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //修改權限名
        $perm = Permission::find($id);
        $res = $perm->update(['perm_name' => $request->get('perm_name'), 'perm_url' => $request->get('perm_url')]);
        if ($res) {
            $data = [
                'status' => 1,
                'message' => '修改權限成功',
            ];
        } else {
            $data = [
                'status' => 0,
                'message' => '修改權限失敗',
            ];
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $perm = Permission::find($id);
        $res = $perm->delete();
        if ($res) {
            $data = [
                'status' => 1,
                'message' => '刪除權限成功',
            ];
        } else {
            $data = [
                'status' => 0,
                'message' => '刪除權限失敗',
            ];
        }
        return $data;
    }

    /**
     * 無訪問權限
     */
    public function noAccess()
    {
        return view('admin.public.noAccess');
    }
}
