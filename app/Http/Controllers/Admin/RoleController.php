<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Permission;
use App\Model\Role;
use App\Model\User;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //獲取角色INFO
        // $role = Role::get();
        $role = Role::paginate(10);
        // dd($role);
        //返回角色列表頁面
        return view('admin.role.list', compact('role', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //角色添加頁面
        return view('admin.role.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //新增角色
        $input = $request->all();

        //是否重名
        $res = Role::where('role_name', $input['role_name'])->first();
        if ($res) {
            $data = [
                'status' => 0,
                'message' => '角色名重複',

            ];
            return $data;
        }

        //新增
        $res = Role::create($input);
        if ($res) {
            $data = [
                'status' => 1,
                'message' => '角色新增成功',

            ];
        } else {
            $data = [
                'status' => 0,
                'message' => '角色新增失敗',

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
        //id取得role
        $role = Role::find($id);
        //展示編輯頁面
        return view('admin.role.edit', compact('role'));
    }

    /**
     * Updata the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role_name = $request->input('role_name');
        $role = Role::find($id);
        $role->role_name = $role_name;
        $res = $role->save();
        if ($res) {
            $data = [
                'status' => 1,
                'message' => '修改角色成功',

            ];
        } else {
            $data = [
                'status' => 0,
                'message' => '修改角色失敗',

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
        $res = Role::destroy($id);
        if ($res) {
            $data = [
                'status' => 1,
                'message' => '刪除角色成功',

            ];
        } else {
            $data = [
                'status' => 0,
                'message' => '刪除角色失敗',

            ];
        }
        return $data;
    }

    /**
     *  角色權限頁面
     */
    public function auth($id)
    {
        $role = Role::find($id);
        $perms = Permission::OrderBy('perm_name')->get();
        $own_perm = $role->permission;
        $own_perms = [];
        foreach ($own_perm as $key => $value) {
            $own_perms[] = $value->id;
        }
        return view('admin.role.auth', compact('role', 'perms', 'own_perms'));
    }

    /**
     * 執行角色權限修改
     */
    public function doauth(Request $request)
    {
        $input = $request->all();
        // dd($input);
        \DB::table('role_permission')->where('role_id', $input['role_id'])->delete();
        if (!empty($input['permission_id'])) {
            foreach ($input['permission_id'] as $p) {
                \DB::table('role_permission')->insert(['role_id' => $input['role_id'], 'permission_id' => $p]);
            }
        }
        $data = [
            'status' => 1,
            'message' => '修改權限成功',

        ];
        $this->rePerm();
        return $data;
    }

    /**
     * 權限session 重新寫入
     */
    public function rePerm()
    {
        $user_info = session()->get('user');
        $user = User::find($user_info->user_id);
        $perm_url = [];
        foreach ($user->role as $r) {
            $perm = $r->permission;
            foreach ($perm as $p) {
                $perm_url[] = 'App\\Http\\Controllers\\' . $p->perm_url;
            }
        }
        $perm_url = array_unique($perm_url);
        session()->put('perm_url', $perm_url);
    }
}
