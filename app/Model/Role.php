<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //角色模型關聯表
    //自動找model名複數英文表loles
    //關聯表主鍵
    public $primaryKey = 'id';
    //禁用時間戳
    // public $timestamps = false;
    //除了[]允許批量操作
    public $guarded = [];

    //動態屬性，關聯角色權限
    public function permission()
    {
        return $this->belongsToMany('App\Model\Permission', 'role_permission', 'role_id', 'permission_id');
    }
}
