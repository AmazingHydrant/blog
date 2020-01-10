<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Cate;

class cateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //分類頁面
        // $cate = Cate::paginate(10);
        $cate = (new Cate())->tree();
        // dd($cate);
        return view('admin.cate.list', compact('cate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //添加分類頁面
        $cate = Cate::where('cate_pid', 0)->get();
        return view('admin.cate.add', compact('cate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //執行添加操作

        $input = $request->all();
        // return $input;
        $data = [
            'status' => 0,
            'message' => '新增分類失敗'
        ];
        //判斷是否重名
        $res = Cate::where('cate_name', $input['cate_name'])->first();
        if ($res) {
            $data['message'] = '分類名稱重複';
            return $data;
        }
        $input['cate_title'] = $input['cate_title'] ? $input['cate_title'] : $input['cate_name'];
        $input['cate_order'] = $input['cate_order'] ? $input['cate_order'] : 1;
        $res = Cate::create($input);
        if ($res) {
            $data['status'] = 1;
            $data['message'] = '新增分類成功';
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
        //
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
        //修改分類
        $input = $request->except('dataType');
        // return $input;
        $data = [
            'status' => 0,
            'message' => '修改分類失敗'
        ];
        $cate = Cate::find($id);
        $res = $cate->update($input);
        if ($res) {
            $data['status'] = 1;
            $data['message'] = '修改分類成功';
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
    }
}
