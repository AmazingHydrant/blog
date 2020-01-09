<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //權限模型關聯表
    //自動找model名複數英文表permissions
    //關聯表主鍵
    public $primaryKey = 'id';
    //禁用時間戳
    public $timestamps = false;
    //除了 允許批量操作
    public $guarded = [];
}
