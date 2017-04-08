<?php

namespace App\Models;


//接口返回数据  现在的接口要适应Android，ios，还有更多的网页应用
class M3Result {

  public $status;//状态
  public $message;//信息返回

  public function toJson()//转换成json数据流
  {
    return json_encode($this, JSON_UNESCAPED_UNICODE);//
  }

}
