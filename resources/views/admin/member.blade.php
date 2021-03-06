@extends('admin.master')

@section('content')
<div class="pd-20">
	<div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
			{{-- <a href="javascript:;" onclick="category_add('添加会员','/admin/member_add')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加会员</a> --}}
		</span>
		<span class="r">共有数据：<strong>{{count($members)}}</strong> 条</span>
	</div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="80">ID</th>
				<th width="100">昵称</th>
				<th width="40">手机号</th>
				<th width="90">邮箱</th>
				<th width="50">邮箱是否激活</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($members as $member)
				<tr class="text-c">
					<td>{{$member->id}}</td>
					<td>{{$member->nickname}}</td>
					<td>{{$member->phone}}</td>
					<td>{{$member->email}}</td>
					<td class="td-status">
					@if($member->email != null)
            @if($member->active == 1)
					    <span class="label label-success radius">已激活</span>
            @else
              <span class="label label-danger radius">未激活</span>
  					@endif
          @endif</td>
					<td class="td-manage">
						<a title="编辑" href="javascript:;" onclick="member_edit('编辑类别','/admin/member_edit?id={{$member->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
						<a title="删除" href="javascript:;" onclick='member_del("{{$member->nickname}}", "{{$member->id}}")' class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
				</tr>
			@endforeach

		</tbody>
	</table>
	</div>
</div>
@endsection

@section('my-js')
<script type="text/javascript">
	function member_edit(title, url) {
		var index = layer.open({
			type: 2,
			title: title,
			content: url
		});
		layer.full(index);
	}

    function member_del(name, id) {
        layer.confirm('确认要删除【' + name + '】吗？', function (index) {
            //此处请求后台程序，下方是成功后的前台处理……
            $.ajax({
                type: 'post', // 提交方式 get/post
                url: '/admin/service/member/del', // 需要提交的 url
                dataType: 'json',
                data: {
                    id: id,
                    _token: "{{csrf_token()}}"
                },
                success: function (data) {
                    if (data == null) {
                        layer.msg('服务端错误', {icon: 2, time: 2000});
                        return;
                    }
                    if (data.status != 0) {
                        layer.msg(data.message, {icon: 2, time: 2000});
                        return;
                    }

                    layer.msg(data.message, {icon: 1, time: 2000});
                    location.replace(location.href);//刷新当前页面
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    layer.msg('ajax error', {icon: 2, time: 2000});
                },
                beforeSend: function (xhr) {
                    layer.load(0, {shade: false});
                }
            });
        });
    }

</script>
@endsection
