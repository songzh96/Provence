<?php

namespace App\Models;

class M3Email {
    //发送给多个人可以使用数组
  public $from;  // 发件人邮箱
  public $to; // 收件人邮箱
  public $cc; // 抄送
  public $attach; // 附件
  public $subject; // 主题
  public $content; // 内容

}
