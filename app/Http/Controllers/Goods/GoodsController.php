<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GoodsModel;

class GoodsController extends Controller
{
    //商品详情
    public function detail()
    {
        $goods_id = $_GET['id'];  //接受url的get方式穿参数（id）
        echo $goods_id;
        //查询商品详情
        $info = GoodsModel::where(['goods_id' => $goods_id])->get()->toArray();
        var_dump($info);
    }
}



