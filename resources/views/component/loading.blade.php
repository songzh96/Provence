{{--
  Created by PhpStorm.
  User: Miracle
  Date: 2017/4/5
  Time: 17:51
 --}}
<!-- loading toast -->
<div class="page">
    <div class="page__hd">
        <h1 class="page__title">Toast</h1>
        <p class="page__desc">弹出式提示</p>
    </div>
    <div class="page__bd page__bd_spacing">
        <a href="javascript:;" class="weui-btn weui-btn_default" id="showToast">成功提示</a>
        <a href="javascript:;" class="weui-btn weui-btn_default" id="showLoadingToast">加载中提示</a>
    </div>
    <div class="page__ft">
        <a href="javascript:home()"><img src="weui/src/example/images/icon_footer_link.png" /></a>
    </div>

    <!--BEGIN toast-->
    <div id="toast" style="display: none;">
        <div class="weui-mask_transparent"></div>
        <div class="weui-toast">
            <i class="weui-icon-success-no-circle weui-icon_toast"></i>
            <p class="weui-toast__content">已完成</p>
        </div>
    </div>
    <!--end toast-->

    <!-- loading toast -->
    <div id="loadingToast" style="display:none;">
        <div class="weui-mask_transparent"></div>
        <div class="weui-toast">
            <i class="weui-loading weui-icon_toast"></i>
            <p class="weui-toast__content">数据加载中</p>
        </div>
    </div>
</div>

