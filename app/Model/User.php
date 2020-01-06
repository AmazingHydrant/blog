<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //用戶模型關聯表
    //自動找model名複數英文表users
    // public $table = 'users';
    //關聯表主鍵
    public $primaryKey = 'user_id';
    //禁用時間戳
    public $timestamps = false;
    //允許批量操作
    protected $fillable = [
        'user_name', 'user_pass', 'email',
    ];
}
