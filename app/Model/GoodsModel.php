<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsModel extends Model
{
    //
    public $table = 'p_goods';   //表名
    protected $primaryKey = 'goods_id';   //主键
}
