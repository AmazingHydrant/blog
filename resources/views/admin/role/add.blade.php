<!DOCTYPE html>
<html class="x-admin-sm">

<head>
    <meta charset="UTF-8">
    <title>新增群組</title>
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
                        <span class="x-red">*</span>群組名</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_username" name="role_name" required="" lay-verify="" autocomplete="off" class="layui-input"></div>
                </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label"></label>
                    <button class="layui-btn" lay-filter="add" lay-submit="">增加</button></div>
            </form>
        </div>
    </div>
    <script>
        layui.use(['form', 'layer', 'jquery'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                    layer = layui.layer;

                // 自定义验证规则
                form.verify({
                    username: function(value) {
                        if (value.length < 1) {
                            return '群組名至少得1個字';
                        }
                    },
                    //     pass: [/(.+){4,16}$/, '密碼必须4到16位'],
                    //     repass: function(value) {
                    //         if ($('#L_pass').val() != $('#L_repass').val()) {
                    //             return '兩次密碼不一致';
                    //         }
                    //     }
                });

                //监听提交
                form.on('submit(add)',
                    function(data) {
                        //发异步，把数据提交给php
                        $.ajax({
                            url: '/admin/role',
                            type: 'POST',
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
                                            $('#L_username').select();
                                            // 可以对父窗口进行刷新 
                                            // xadmin.father_reload();
                                        });
                                }
                            },
                            error: function() {
                                //失敗
                                layer.alert("增加失敗", {
                                        icon: 5
                                    },
                                    function(i) {
                                        //关闭当前frame
                                        layer.close(i);
                                        $('#L_username').select();
                                        // 可以对父窗口进行刷新 
                                        // xadmin.father_reload();
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