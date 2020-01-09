<!DOCTYPE html>
<html class="x-admin-sm">

<head>
    <meta charset="UTF-8">
    <title>編輯用戶</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,perm-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('admin.public.styles')
    @include('admin.public.script')
</head>

<body>
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form">
                <div class="layui-form-item">
                    <label for="L_permname" class="layui-form-label">
                        <span class="x-red">*</span>權限名</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_permname" value="{{$perm->perm_name}}" name="perm_name" required="" lay-verify="permname" autocomplete="off" class="layui-input"></div>
                </div>
                <div class="layui-form-item">
                    <label for="L_permname" class="layui-form-label">
                        <span class="x-red">*</span>權限路由</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_permname" value="{{$perm->perm_url}}" name="perm_url" required="" lay-verify="permname" autocomplete="off" class="layui-input"></div>
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
                    rolename: function(value) {
                        if (value.length < 1) {
                            return '角色名至少得1個字';
                        }
                    },
                });

                //监听提交
                form.on('submit(edit)',
                    function(data) {
                        //发异步，把数据提交给php
                        $.ajax({
                            url: '/admin/permission/{{$perm->id}}',
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
                                            $('#L_rolename').select();
                                            // 可以对父窗口进行刷新 
                                            // xadmin.father_reload();
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
                                        $('#L_rolename').select();
                                        // 可以对父窗口进行刷新 
                                        // xadmin.father_reload();
                                    });
                            }
                        });
                        console.log(data);
                        return false;
                    });

            });
    </script>
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</body>

</html>