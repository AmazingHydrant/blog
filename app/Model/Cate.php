<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    protected $table = 'cates';
    //主鍵
    public $primaryKey = 'cate_id';
    //禁用時間戳
    public $timestamps = false;
    //除了 允許批量操作
    public $guarded = [];

    public function tree()
    {
        $cate_main = $this->where('cate_pid', 0)->orderBy('cate_order', 'asc')->get();
        $cate_2nd = $this->where('cate_pid', '>', 0)->orderBy('cate_order', 'asc')->get();
        $cate_tree = [];
        foreach ($cate_main as $v) {
            $cate_tree[] = $v;
            foreach ($cate_2nd as $val) {
                if ($val->cate_pid == $v->cate_id) {
                    $val->cate_name = '|--- ' . $val->cate_name;
                    $cate_tree[] = $val;
                }
            }
        }
        return $cate_tree;
    }
}
