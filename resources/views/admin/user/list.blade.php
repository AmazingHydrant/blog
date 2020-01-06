<!DOCTYPE html>
<html class="x-admin-sm">

<head>
  <meta charset="UTF-8">
  <title>後臺用戶列表</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
  @include('admin.public.styles')
  @include('admin.public.script')
</head>

<body>
  <div class="x-nav">
    <span class="layui-breadcrumb">
      <a href="">首頁</a>
      <a>
        <cite>導覽</cite></a>
    </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
      <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
  </div>
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-body">
            <form method="get" action="/admin/user" class="layui-form layui-col-space5" style="text-align:center;">
              <div class=" layui-inline layui-show-xs-block">
                <input type="text" name="user_name" value="{{$request->input('user_name')}}" placeholder="請输入用戶名" autocomplete="off" class="layui-input">
              </div>
              <div class="layui-inline layui-show-xs-block">
                <input type="text" name="email" value="{{$request->input('email')}}" placeholder=" 請输入email" autocomplete="off" class="layui-input">
              </div>
              <div class="layui-inline layui-show-xs-block">
                <button class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
              </div>
            </form>
          </div>
          <div class="layui-card-header">
            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
            <button class="layui-btn" onclick="xadmin.open('新增會員','/admin/user/create',600,400)"><i class="layui-icon"></i>新增</button>
          </div>
          <div class="layui-card-body layui-table-body layui-table-main">
            <table class="layui-table layui-form">
              <thead>
                <tr>
                  <th>
                    <input type="checkbox" lay-filter="checkall" name="" lay-skin="primary">
                  </th>
                  <th>ID</th>
                  <th>用戶名</th>
                  <th>email</th>
                  <th>狀態</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
                @foreach($user as $u)
                <tr>
                  <td>
                    <input type="checkbox" name="id" value="{{$u->user_id}}" lay-skin="primary">
                  </td>
                  <td>{{$u->user_id}}</td>
                  <td>{{$u->user_name}}</td>
                  <td>{{$u->email}}</td>
                  <td class="td-status">
                    <span class="layui-btn layui-btn-normal layui-btn-mini">已啟用</span></td>
                  <td class="td-manage">
                    <a onclick="member_stop(this,'10001')" href="javascript:;" title="启用">
                      <i class="layui-icon">&#xe601;</i>
                    </a>
                    <a title="编辑" onclick="xadmin.open('编辑','/admin/user/{{$u->user_id}}/edit',600,400)" href="javascript:;">
                      <i class="layui-icon">&#xe642;</i>
                    </a>
                    <a onclick="xadmin.open('修改密碼','member-password.html',600,400)" title="修改密碼" href="javascript:;">
                      <i class="layui-icon">&#xe631;</i>
                    </a>
                    <a title="删除" onclick="member_del(this,'{{$u->user_id}}')" href="javascript:;">
                      <i class="layui-icon">&#xe640;</i>
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="layui-card-body ">
            <div class="page">
              <div>
                {{$user->render()}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script>
  layui.use(['laydate', 'form'], function() {
    var laydate = layui.laydate;
    var form = layui.form;


    // 监听全选
    form.on('checkbox(checkall)', function(data) {

      if (data.elem.checked) {
        $('tbody input').prop('checked', true);
      } else {
        $('tbody input').prop('checked', false);
      }
      form.render('checkbox');
    });

    //执行一个laydate实例
    laydate.render({
      elem: '#start' //指定元素
    });

    //执行一个laydate实例
    laydate.render({
      elem: '#end' //指定元素
    });


  });

  /*用户-停用*/
  function member_stop(obj, id) {
    layer.confirm('确认要停用吗？', function(index) {

      if ($(obj).attr('title') == '启用') {

        //发异步把用户状态进行更改
        $(obj).attr('title', '停用')
        $(obj).find('i').html('&#xe62f;');

        $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
        layer.msg('已停用!', {
          icon: 5,
          time: 1000
        });

      } else {
        $(obj).attr('title', '启用')
        $(obj).find('i').html('&#xe601;');

        $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
        layer.msg('已启用!', {
          icon: 5,
          time: 1000
        });
      }

    });
  }

  /*用户-删除*/
  function member_del(obj, id) {
    layer.confirm('確定要删除吗？', function(index) {
      //发异步删除数据
      $.post('/admin/user/' + id, {
          '_method': 'delete',
          '_token': " {{csrf_token()}}"
        },
        function(data) {
          // console.log(data);
          if (data.status == 1) {
            $(obj).parents("tr").remove();
            layer.msg(data.message, {
              icon: 1,
              time: 2000
            });
          } else {
            layer.msg(data.message, {
              icon: 0,
              time: 2000
            });
          }
        }
      );

    });
  }



  function delAll(argument) {
    var ids = [];

    // 获取选中的id 
    $('tbody input').each(function(index, el) {
      if ($(this).prop('checked')) {
        ids.push($(this).val())
      }
    });

    layer.confirm('確定要删除吗？' + ids.toString(), function(index) {
      //捉到所有被选中的，发异步进行删除
      $.post('/admin/user/del', {
        'ids': ids,
        '_token': " {{csrf_token()}}",
      }, function(data) {
        if (data.status == 1) {
          $(".layui-form-checked").not('.header').parents('tr').remove();
          layer.msg(data.message, {
            icon: 1
          });
        } else {
          layer.msg(data.message, {
            icon: 0
          });
        }
      });

    });
  }
</script>

</html>