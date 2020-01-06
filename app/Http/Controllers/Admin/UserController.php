<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //用戶列表

        // $input = $request->all();
        // dd($request->all());
        $user = User::OrderBy('user_id', 'asc')
            ->where(function ($query) use ($request) {
                $user_name = $request->input('user_name');
                if (!empty($user_name)) {
                    $query->where('user_name', 'like', '%' . $user_name . '%');
                }
                $email = $request->input('email');
                if (!empty($email)) {
                    $query->where('email', 'like', '%' . $email . '%');
                }
            })
            ->paginate(5);
        // $user = User::paginate(1);
        // dd($user[0]['email']);
        // dd($request->all());
        return view('admin.user.list', compact('user', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //展示用戶添加列表
        return view('admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //執行用戶添加
        $input = $request->all();
        $user_name = $input['user_name'];
        $user_pass = Crypt::encrypt($input['user_pass']);
        $email = $input['email'];
        $res = User::create(['user_name' => $user_name, 'user_pass' => $user_pass, 'email' => $email]);
        if ($res) {
            $data = ['status' => 1, 'message' => '新增成功'];
        } else {
            $data = ['status' => 0, 'message' => '新增失敗'];
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
        //尋找用戶INFO
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
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
        //要修改的用戶
        $user = User::find($id);
        $user->user_name = $request->input('user_name');
        $user->email = $request->input('email');
        $res = $user->save();
        if ($res) {
            $data = [
                'status' => 1,
                'message' => '修改成功',
            ];
        } else {
            $data = [
                'status' => 0,
                'message' => '修改失敗',
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
        $user = User::find($id);
        $res = $user->delete();
        if ($res) {
            $data = [
                'status' => 1,
                'message' => '刪除成功',
            ];
        } else {
            $data = [
                'status' => 0,
                'message' => '刪除失敗',
            ];
        }
        return $data;
    }

    /**
     * 批量刪除用戶
     * 
     * @param array $ids
     * @reru
     */
    public function delAll(Request $request)
    {
        $res = User::destroy($request->input('ids'));
        if ($res) {
            $data = [
                'status' => 1,
                'message' => '刪除成功',
            ];
        } else {
            $data = [
                'status' => 0,
                'message' => '刪除失敗',
            ];
        }
        return $data;
    }
}
