<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     * 後臺登錄頁面
     */
    public function login()
    {
        if (session()->get('user')) {
            return redirect('admin/index');
        }
        return view('admin\login');
    }

    /**
     * 處理後臺登錄操作
     */
    public function dologin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|between:4,50|alpha_dash',
            'password' => 'required|between:4,255',
            'captcha' => 'required|captcha',
        ], [
            'username.required' => '請輸入用戶名',
            'username.between' => '用戶名長度要求在 4-50 之間',
            'captcha' => 'The captcha field',
        ]);
        //上面驗證失敗，會導到原POST網址，拋出錯誤訊息 用$errors->all()接受
        //且代碼不會往下執行

        $db = DB::table('data_user');
        $user_info = $db->where('user_name', $request['username'])->first();
        if (!$user_info) {
            return redirect('admin/login')->with('errors', '用戶名錯誤');
        }
        if ($user_info->user_pass != md5($request['password'])) {
            return redirect('admin/login')->with('errors', '密碼錯誤');
        }
        //驗證成功繼續

        session()->put('user', $user_info);
        return  redirect('admin/index');
    }

    /**
     * 後臺首頁
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * 後臺歡迎頁面
     */
    public function welcome()
    {
        return view('admin.welcome');
    }

    /**
     * 統計頁面
     */
    public function welcome1()
    {
        return view('admin.welcome1');
    }

    /**
     * 登出
     */
    public function logout()
    {
        session()->flush();
        return redirect('admin/login');
    }
}
