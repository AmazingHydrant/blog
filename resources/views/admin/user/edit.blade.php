<!DOCTYPE html>
<html class="x-admin-sm">

<head>
    <meta charset="UTF-8">
    <title>編輯用戶</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('admin.public.styles')
    @include('admin.public.script')
</head>

<body>
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form">
                <div class="layui-form-item">
                    <label for="L_username" class="layui-form-label">
                        <span class="x-red">*</span>用戶名</label>
                    <div class="layui-input-inline">
                        <input type="hidden" value="{{$user->user_id}}" name="user_id">
                        <input type="text" id="L_username" value="{{$user->user_name}}" name="user_name" required="" lay-verify="username" autocomplete="off" class="layui-input"></div>
                </div>
                <div class="layui-form-item">
                    <label for="L_email" class="layui-form-label">
                        <span class="x-red">*</span>電子信箱</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_email" value="{{$user->email}}" name="email" required="" lay-verify="email" autocomplete="off" class="layui-input"></div>
                    <div class="layui-form-mid layui-word-aux">
                        <!-- <span class="x-red">*</span></div> -->
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">群組</label>
                        <div class="layui-input-block">
                            @foreach($roles as $r)
                            @if(in_array($r->id,$own_roles))
                            <input type="checkbox" name="role_id[]" title="{{$r->role_name}}" value="{{$r->id}}" lay-skin="primary" checked>
                            @else
                            <input type="checkbox" name="role_id[]" title="{{$r->role_name}}" value="{{$r->id}}" lay-skin="primary">
                            @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button class="layui-btn" lay-filter="edit" lay-submit="">修改</button></div>
            </form>
        </div>
    </div>
    <script>
        layui.use(['form', 'layer', 'jquery'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                    layer = layui.layer;

                //自定义验证规则
                form.verify({
                    username: function(value) {
                        if (value.length < 4) {
                            return '用戶名至少得4個字';
                        }
                    },
                });

                //监听提交
                form.on('submit(edit)',
                    function(data) {
                        //发异步，把数据提交给php
                        $.ajax({
                            url: '/admin/user/' + data.field['user_id'],
                            type: 'PUT',
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: data.field,
                            success: function(data) {
                                //成功
                                if (data.status == 1) {
                                    layer.alert(data.message, {
                                            icon: 6
                                        },
                                        function(i) {
                                            //关闭当前frame
                                            layer.close(i);
                                            // 可以对父窗口进行刷新 
                                            xadmin.father_reload();
                                        });
                                } else {
                                    layer.alert(data.message, {
                                            icon: 5
                                        },
                                        function(i) {
                                            //关闭当前frame
                                            layer.close(i);
                                            // 可以对父窗口进行刷新 
                                            xadmin.father_reload();
                                        });
                                }

                            },
                            error: function() {
                                //失敗
                                layer.alert("修改失敗", {
                                        icon: 5
                                    },
                                    function(i) {
                                        //关闭当前frame
                                        layer.close(i);

                                        // 可以对父窗口进行刷新 
                                        xadmin.father_reload();
                                    });
                            }
                        });
                        // console.log(data);
                        return false;
                    });

            });
    </script>
</body>

</html>