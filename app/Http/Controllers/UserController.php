<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

class UserController extends Controller
{
    //取得添加頁面
    /**
     * 取得添加頁面
     * @param null
     * @return 添加頁面
     */
    public function add()
    {
        return view('user/add');
    }

    //執行用戶添加操作
    /**
     * 取得添加頁面
     * @param 提交的表單數據
     * @return 添加是否成功
     */
    public function store(Request $request)
    {
        //獲取用戶提交數據
        // $input = $request->except('_token');
        $input = $request->all();
        $input['user_pass'] = md5($input['user_pass']);
        $res = User::create($input);
        if ($res) {
            return redirect('user/index');
        } else {
            return back();
        }
        return $res;
    }

    /**
     * 用戶列表頁面
     * @param null
     * @return 用戶列表頁面
     */
    public function index()
    {
        //取得用戶數據
        // $user = DB::table('data_user')->get();
        $user = User::get();
        //返回用戶列表
        return view('user/list')->with('user', $user);
    }

    /**
     * 用戶修改頁面
     * @param null
     * @return 用戶列表頁面
     */
    public function edit($id)
    {
        //用用戶id找
        $user = User::find($id);

        //返回用戶列表
        return view('user/edit')->with('user', $user);
    }

    /**
     * 執行用戶修改
     * @param null
     * @return 用戶列表頁面
     */
    public function update(Request $request)
    {
        // 用id找用戶
        // $input = $request->except('_token');
        $input = $request->all();
        $input['user_pass'] = md5($input['user_pass']);
        $user = User::find($input['user_id']);
        // dd($user);
        // $res = $user->update(['user_name' => $input['user_name']]);
        $res = $user->update($input);
        if ($res) {
            return redirect('user/index');
        } else {
            return back();
        }
    }

    /**
     * 執行用戶刪除
     * @param null
     * @return 是否刪除成功
     */
    public function del($id)
    {
        //用用戶id找
        $res = User::find($id)->delete();
        if ($res) {
            $date = [
                'status' => 1,
                'message' => '刪除成功'
            ];
        } else {
            $date = [
                'status' => 0,
                'message' => '刪除失敗'
            ];
        }
        //返回用戶列表
        return $date;
    }
}
